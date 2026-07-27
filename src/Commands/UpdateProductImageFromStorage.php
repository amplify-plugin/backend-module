<?php

namespace Amplify\System\Backend\Commands;

use Amplify\System\Backend\Jobs\ProductImage\DispatchProcessCodesFromTableJob;
use Amplify\System\Backend\Jobs\ProductImage\ScanScanningFolderToTableJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class UpdateProductImageFromStorage extends Command
{
    protected $signature = 'update:product-images {--rescan=1 : Rescan staging folder and rebuild product_image_files table}';

    protected $description = 'Sync product images from staging folder (file-based only)';

    public function handle(): int
    {
        $rescan = $this->wantsRescan();

        Bus::chain([
            new ScanScanningFolderToTableJob($rescan),
            new DispatchProcessCodesFromTableJob,
        ])->dispatch();

        $this->info(
            $rescan
                ? 'Chained jobs dispatched (full rebuild scan -> process codes).'
                : 'Chained jobs dispatched (incremental scan -> process codes).'
        );

        return self::SUCCESS;
    }

    private function wantsRescan(): bool
    {
        // Signature default is "1" when omitted.
        // Bare `--rescan` (optional value) yields null → treat as enabled.
        // Scheduler / schedule:list form `--rescan=1` / `--rescan='1'` is accepted.
        $value = $this->option('rescan');

        if ($value === null) {
            return true;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
