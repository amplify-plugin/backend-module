<?php

use Amplify\System\Backend\Models\Category;

if (! function_exists('eaDefaultCategories')) {
    function eaDefaultCategories($requestFromModule): array
    {
        $categories = Category::query()
            ->whereNull('parent_id')
            ->withCount('products')
            ->get();

        return $categories->map(function ($category) {
            return [
                'ids' => $category->id,
                'name' => $category->category_name,
                'nodeString' => $category->category_code,
                'productCount' => $category->products_count,
            ];
        })->toArray();
    }
}
