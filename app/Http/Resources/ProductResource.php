<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'bars_id' => $this->bars_id,
            'categories_id' => $this->categories_id,
            'erp_id' => $this->erp_id,
            'short_name' => $this->short_name,
            'short_description' => $this->short_description,
            'marca' => $this->marca,
            'unity' => $this->unity,
            'price_base' => $this->price_base,
            'image_url' => $this->image_url,
            'order' => $this->order,
            // 'promo_list' => PromoListResource::collection($this->promos_list),
            'promos' => ProductPromoListResource::collection($this->products_promos_Lists),
        ];
    }
}
