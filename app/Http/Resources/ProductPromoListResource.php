<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductPromoListResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'promos_lists_id' => $this->promos_lists_id,
            'products_id' => $this->products_id,
            'hour_start' => $this->hour_start,
            'hour_end' => $this->hour_end,
            'price' => $this->price,
            'active' => $this->active,
        ];
    }
}
