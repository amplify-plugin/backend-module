<?php

namespace Amplify\System\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductClassificationResource extends JsonResource
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
            'min' => $this->pivot->min,
        ];
    }
}
