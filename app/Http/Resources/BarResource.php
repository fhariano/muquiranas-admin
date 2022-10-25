<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BarResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'erp_id' => $this->erp_id,
            'short_name' => $this->short_name,
            'address' => $this->address,
            'city_state' => $this->city_state,
            'image_url' => $this->image_url,
            'order' => $this->order,
            // 'categories' => CategoryCollection::collection($this->categories),
        ];
    }
}
