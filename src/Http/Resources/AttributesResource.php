<?php

namespace Amplify\System\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'productClassifications' => ProductClassificationResource::collection($this->productClassifications),
        ];
    }
}
