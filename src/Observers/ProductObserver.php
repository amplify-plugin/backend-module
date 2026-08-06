<?php

namespace Amplify\System\Backend\Observers;

use Amplify\System\Backend\Models\Product;
use Amplify\System\Backend\Models\SkuProduct;

class ProductObserver
{
    /**
     * Handle the "created" event.
     *
     * @return void
     */
    public function created($model)
    {
        //
    }

    /**
     * Handle the "updated" event.
     *
     * @return void
     */
    public function updated($model)
    {
        if (! $model->has_sku || ! $model->wasChanged('manufacturer_id')) {
            return;
        }

        $skuIds = SkuProduct::where('parent_id', $model->id)->pluck('sku_id');

        if ($skuIds->isNotEmpty()) {
            Product::whereIn('id', $skuIds)->update([
                'manufacturer_id' => $model->manufacturer_id,
            ]);
        }

        Product::where('parent_id', $model->id)->update([
            'manufacturer_id' => $model->manufacturer_id,
        ]);
    }

    /**
     * Listen to the updating event.
     *
     * @return void
     */
    public function updating($model)
    {
        if ($model->is_new === 1) {
            $model->is_new = 0;
        }

        if (! $model->is_updated) {
            $model->is_updated = 0;
        }
    }

    /**
     * Listen to the creating event.
     *
     * @return void
     */
    public function creating($model)
    {
        //
    }

    /**
     * Handle the "deleted" event.
     *
     * @return void
     */
    public function deleted($model)
    {
        //
    }

    /**
     * Handle the "restored" event.
     *
     * @return void
     */
    public function restored($model)
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted($model)
    {
        //
    }
}
