<?php

namespace Amplify\System\Backend\Jobs\ProductImage;

use Amplify\System\Backend\Models\ProductImageFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DispatchProcessCodesFromTableJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 3600;

    public int $tries = 2;

    public function handle(): void
    {
        $chunk = (int) config('amplify.pim.product_images.code_chunk', 500);

        ProductImageFile::query()
            ->select('code')
            ->whereNotNull('code')
            ->groupBy('code')
            ->orderBy('code')
            ->chunk($chunk, function ($rows) {
                $codes = $rows->pluck('code')->filter()->values()->all();

                if (empty($codes)) {
                    return;
                }

                ProcessProductImageCodesJob::dispatch($codes);
            });
    }
}
