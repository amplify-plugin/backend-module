<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\Product;
use Amplify\System\Backend\Models\ProductImage;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BulkProductImageUpdateController extends BackpackCustomCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function setup()
    {
        CRUD::setEntityNameStrings('image-to-bulk-products', 'image to bulk products');
    }

    public function imageForBulkProducts()
    {
        $this->crud->setHeading('Add Image to Products', 'edit');
        $this->crud->setUpdateContentClass('col-md-12');

        $this->data['title'] = 'Add Image to Products';

        return view('backend::pages.product.update-product-image', array_merge(['crud' => $this->crud], $this->data));
    }

    /**
     * @return JsonResponse
     */
    public function updateProductImages(Request $request)
    {
        $validated = $request->validate([
            'image_path' => ['required', 'string'],
            'product_ids' => ['required', 'array'],
            'product_ids.*' => ['integer'],
        ]);

        $imagePath = $validated['image_path'];
        $productIds = array_values(array_unique($validated['product_ids']));

        // 1) Find which products actually exist (avoid inserting for invalid IDs)
        $existingProductIds = Product::whereIn('id', $productIds)->pluck('id')->all();

        if (empty($existingProductIds)) {
            return response()->json(['message' => 'No valid products found.'], 404);
        }

        // 2) Fetch existing product_images for these products (key by product_id)
        $existingImages = ProductImage::whereIn('product_id', $existingProductIds)
            ->select('id', 'product_id')
            ->get()
            ->keyBy('product_id');

        $now = Carbon::now();

        // 3) Bulk update existing image rows in ONE query
        $existingImageIds = $existingImages->pluck('id')->all();
        if (! empty($existingImageIds)) {
            ProductImage::whereIn('id', $existingImageIds)->update([
                'main' => $imagePath,
                'updated_at' => $now,
            ]);
        }

        // 4) Bulk insert missing image rows in ONE query
        $missingProductIds = array_values(array_diff($existingProductIds, $existingImages->keys()->all()));

        if (! empty($missingProductIds)) {
            $insertRows = array_map(function ($pid) use ($imagePath, $now) {
                return [
                    'product_id' => $pid,
                    'main' => $imagePath,
                    'thumbnail' => null,
                    'additional' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }, $missingProductIds);

            ProductImage::insert($insertRows);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product images updated.',
            'updated_existing' => count($existingImageIds),
            'created_missing' => count($missingProductIds),
        ]);
    }
}
