<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Contact login identifier migration.
 *
 * - Removes the UNIQUE constraint from `contacts.email` (email is no longer a login identifier
 *   and no longer needs to be unique).
 * - Replaces the normal `contacts.login_id` index with a UNIQUE index.
 * - `login_id` intentionally remains NULLABLE (a UNIQUE index allows multiple NULLs).
 *
 * SAFETY / PRE-FLIGHT (see .docs/contact-login-id-implementation-plan.md §5):
 * Run `php artisan amplify:bkd-backfill-contact-login-id` BEFORE this migration.
 * This migration refuses to run while a simulated backfill (NULL/empty login_id -> email)
 * would still produce duplicate login IDs. NULL/empty login_id rows are allowed to remain
 * (they do not violate the unique index) but should be backfilled for contacts to log in.
 *
 * NOTE on `down()`: restoring the UNIQUE constraint on `email` fails if duplicate emails were
 * created while the constraint was absent. This is expected and documented.
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->assertNoSimulatedLoginIdConflicts();

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropUnique('contacts_email_unique');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex('contacts_login_id_index');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->unique('login_id');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropUnique('contacts_login_id_unique');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->index('login_id');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->unique('email');
        });
    }

    /**
     * Abort when the planned NULL/empty login_id -> email backfill would still produce
     * duplicate login IDs. Mirrors the audit's simulation logic exactly.
     */
    private function assertNoSimulatedLoginIdConflicts(): void
    {
        $duplicates = DB::table('contacts')
            ->selectRaw('sim, COUNT(*) AS total')
            ->fromSub(
                DB::table('contacts')
                    ->selectRaw("CASE WHEN login_id IS NOT NULL AND TRIM(login_id) <> '' THEN login_id ELSE email END AS sim")
                    ->where(function ($query) {
                        $query
                            ->whereNotNull('login_id')->where('login_id', '<>', '')
                            ->orWhere(function ($query) {
                                $query->whereNotNull('email')->where('email', '<>', '');
                            });
                    }), 'simulated')
            ->groupBy('sim')
            ->havingRaw('COUNT(*) > 1')
            ->limit(5)
            ->pluck('total', 'sim');

        if ($duplicates->isNotEmpty()) {
            $preview = $duplicates->map(fn ($count, $value) => "\"{$value}\" x{$count}")->implode(', ');

            throw new RuntimeException(sprintf(
                'contacts.login_id cannot be made UNIQUE yet: the planned login_id backfill would produce duplicate login IDs (%s%s). '.
                'Run "php artisan amplify:bkd-backfill-contact-login-id" first, resolve the reported conflicts, then re-run this migration.',
                $preview,
                $duplicates->count() === 5 ? ' …' : ''
            ));
        }
    }
};
