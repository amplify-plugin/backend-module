<?php

namespace Amplify\System\Backend\Jobs\ProductImage;

use Amplify\System\Backend\Services\ProductImageProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessProductImageCodesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public array $codes) {}

    public function handle(ProductImageProcessor $processor): void
    {
        $processor->process($this->codes);
    }
}