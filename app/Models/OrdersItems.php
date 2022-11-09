<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersItems extends Model
{
    use HasFactory;

    protected $table ="orders_items";
    protected $fillable = [
        'item',
        'product_id',
        'quantity',
        'price',
        'total'
    ];

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
