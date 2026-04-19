<?php

namespace Amplify\System\Backend\Commands;

use Amplify\System\Backend\Models\Product;
use Amplify\System\Backend\Jobs\GenerateProductSlugJob;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Throwable;

class AddProductSlugCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amplify:bkd-add-product-slug {--chunk=500}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add product slug from product name if slug field is empty.';

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws Throwable
     */
    public function handle()
    {
        $chunkSize = $this->option('chunk');

        try {
            $jobs = [];

            Product::select('id')
                ->whereNull('product_slug')
                ->chunkById($chunkSize, function ($products) use (&$jobs) {
                    $jobs[] = new GenerateProductSlugJob($products->pluck('id')->toArray());
                });

            Bus::batch($jobs)
                ->catch(function (Batch $batch, Throwable $e) {
                    logger()->error($e);
                    throw_if(! app()->isProduction(), $e);
                })
                ->onQueue('worker')
                ->dispatch();

            return self::SUCCESS;
        } catch (\Exception $exception) {
            $this->error($exception);

            return self::FAILURE;
        }
    }
}
