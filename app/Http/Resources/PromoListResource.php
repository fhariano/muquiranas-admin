<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromoListResource extends JsonResource
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
            'bars_id' => $this->bars_id,
            'name' => $this->name,
            'active' => $this->active,
        ];
    }
}
