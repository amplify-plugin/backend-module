<?php

namespace Amplify\System\Backend\Traits;

use App\Models\Product;

trait ProductClassificationTrait
{
    public function fetchAddProductClassificationToProducts(): int
    {
        return Product::query()
            ->whereIn('id', request()->products)
            ->update(['product_classification_id' => request()->productClassificationId]);
    }

    public function fetchRemoveProductClassificationFromProduct(): int
    {
        return Product::query()
            ->where('id', request()->product_id)
            ->update(['product_classification_id' => null]);
    }
}
