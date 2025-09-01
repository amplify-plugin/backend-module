<?php

namespace Amplify\System\Backend\Traits;

use App\Models\CategoryProduct;

trait ProductCategoryTrait
{
    public function fetchAddProductCategoryToProducts(): string
    {
        foreach (request()->products as $productId) {
            CategoryProduct::create(['product_id' => $productId, 'category_id' => request()->productCategoryId]);
        }

        return 'data inserted successfully';
    }

    public function fetchRemoveProductCategoryFromProduct(): int
    {
        $where = [['product_id', request()->product_id], ['category_id', request()->category_id]];

        return CategoryProduct::query()->where($where)->delete();
    }
}
