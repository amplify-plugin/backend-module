<?php

namespace Amplify\System\Backend\Commands;

use Amplify\System\Backend\Models\Contact;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Command\Command as CommandAlias;

class BackfillContactLoginIdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amplify:bkd-backfill-contact-login-id
                            {--dry-run : Show what would be backfilled without modifying any records}
                            {--chunk=500 : Number of contacts loaded per chunk while scanning}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate missing contact login IDs from email addresses. Never overwrites an existing login ID.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $chunkSize = max(1, (int) $this->option('chunk'));

        $totalContacts = Contact::query()->count();

        // Phase 1 (read-only): classify every contact whose login_id is NULL or empty.
        $toBackfill = [];
        $missingEmail = [];
        $conflicts = [];

        Contact::query()
            ->select(['id', 'email', 'login_id'])
            ->where(function ($query) {
                $query->whereNull('login_id')->orWhere('login_id', '');
            })
            ->orderBy('id')
            ->chunkById($chunkSize, function ($contacts) use (&$toBackfill, &$missingEmail, &$conflicts) {
                foreach ($contacts as $contact) {
                    $email = trim((string) $contact->email);

                    if ($email === '') {
                        $missingEmail[] = $contact->getKey();

                        continue;
                    }

                    $conflictingIds = Contact::query()
                        ->whereKeyNot($contact->getKey())
                        ->where('login_id', $email)
                        ->pluck('id');

                    if ($conflictingIds->isNotEmpty()) {
                        $conflicts[] = "contact #{$contact->getKey()} target \"{$email}\" already used by contact(s) #{$conflictingIds->implode(', ')}";

                        continue;
                    }

                    $toBackfill[$contact->getKey()] = $email;
                }
            });

        $scanned = count($toBackfill) + count($missingEmail) + count($conflicts);

        if ($dryRun) {
            $this->warn('DRY RUN — no records were modified.');
        }

        // Phase 2 (write): guarded, targeted updates. The extra whereNull/where('') predicate
        // guarantees an existing login_id can never be overwritten, even on a concurrent race.
        if (! $dryRun && $toBackfill !== []) {
            DB::transaction(function () use ($toBackfill) {
                foreach ($toBackfill as $id => $email) {
                    Contact::query()
                        ->whereKey($id)
                        ->where(function ($query) {
                            $query->whereNull('login_id')->orWhere('login_id', '');
                        })
                        ->update(['login_id' => $email]);
                }
            });
        }

        $this->printSummary($totalContacts, $scanned, count($toBackfill), count($missingEmail) + count($conflicts), $missingEmail, $conflicts, $dryRun);

        if ($dryRun) {
            $this->line('DRY RUN finished. No records were modified.');
        } else {
            $this->line('Backfill finished.');
        }

        if ($missingEmail !== [] || $conflicts !== []) {
            return CommandAlias::FAILURE;
        }

        return CommandAlias::SUCCESS;
    }

    private function printSummary(int $alreadyPopulated, int $scanned, int $backfilled, int $skipped, array $missingEmail, array $conflicts, bool $dryRun): void
    {
        $this->line('Scanned:            '.($alreadyPopulated).' contacts');
        $this->line('Already populated:  '.($alreadyPopulated - $scanned));
        $this->line(($dryRun ? 'Would backfill:     ' : 'Backfilled:         ').$backfilled);
        $this->line('Skipped:            '.$skipped);
        $this->line('Missing email:      '.count($missingEmail).($missingEmail !== [] ? ' — contact ids: '.implode(', ', $missingEmail) : ''));
        $this->line('Conflicts:          '.count($conflicts));

        foreach ($conflicts as $conflict) {
            $this->line("  - {$conflict}");
        }

        $this->line('Errors:             0');
    }
}
