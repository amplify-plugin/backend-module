<?php

namespace Amplify\System\Backend\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductItemsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Product_Id' => $this->id ?? '',
            'Product_Type' => 'normal',
            'Product_Code' => $this->product_code ?? '',
            'Product_Image' => $this->thumbnail ?? '',
            'Product_Name' => $this->product_name ?? '',
            'Status' => 'published',
            'Model_Name' => $this->model_code ?? '',
            'Product_Slug' => $this->product_slug ?? '',
            'Sku_List' => json_encode([]),
        ];
    }
}
