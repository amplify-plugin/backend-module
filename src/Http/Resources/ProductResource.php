<?php

namespace Amplify\System\Backend\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_code' => $this->product_code,
            'product_name' => $this->product_name,
            //            'product_classification' => new ProductClassificationResource($this->productClassification),
            'attributes' => AttributesResource::collection($this->attributes),
        ];
    }
}
