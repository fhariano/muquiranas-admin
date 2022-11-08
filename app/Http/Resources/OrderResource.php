<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'customer_id' => $this->customer_id,
            'bar_id' => $this->bar_id,
            'order_id' => $this->order_id,
            'erp_id' => $this->erp_id,
            'invoice' => $this->invoice,
            'total' => $this->total,
            'order_at' => $this->order_at,
            'insert_for' => $this->insert_for,
            'created_at' => $this->created_at,
            'update_for' => $this->update_for,
            'updated_at' => $this->updated_at,
            'billed' => $this->billed,
            // 'products' => ProductCollection::collection($this->products),
        ];
    }
}
