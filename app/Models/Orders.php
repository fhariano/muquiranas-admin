<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table ="orders";
    protected $fillable = [
        'bar_id',
        'customer_id',
        'order_num',
        'total',
        'order_at',
        'inserted_for'
    ];

    public function Products()
    {
        return $this->belongsToMany(Products::class, 'orders_items', 'order_id', 'product_id');
    }
}
