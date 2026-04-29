<?php

namespace Amplify\System\Backend\Commands;


use Amplify\System\Backend\Jobs\ProductImage\DispatchProcessCodesFromTableJob;
use Amplify\System\Backend\Jobs\ProductImage\ScanScanningFolderToTableJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class UpdateProductImageFromStorage extends Command
{
    protected $signature = 'update:product-images {--rescan : Rescan staging folder and rebuild product_image_files table}';

    protected $description = 'Sync product images from staging folder (file-based only)';

    public function handle(): int
    {
        $rescan = (bool) $this->option('rescan');

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
}
