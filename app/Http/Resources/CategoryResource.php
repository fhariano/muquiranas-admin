<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'bar_id' => $this->bar_id,
            'erp_id' => $this->erp_id,
            'name' => $this->name,
            'icon_data' => $this->icon_data,
            'order' => $this->order,
        ];
    }
}
