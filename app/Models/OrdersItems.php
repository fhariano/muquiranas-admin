<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersItems extends Model
{
    use HasFactory;

    protected $table ="orders_items";
    protected $fillable = [
        'order_id',
        'product_id',
        'item',
        'quantity',
        'total'
    ];

    public function orders()
    {
        return $this->belongsTo(Orders::class);
    }

    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
