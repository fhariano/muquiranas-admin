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
        'client_id',
        'client_identify',
        'order_num',
        'erp_id',
        'invoice',
        'total',
        'order_at',
        'inserted_for',
        'billed'
    ];

    public function Products() // singular
    {
        return $this->belongsToMany(Products::class, 'orders_items', 'order_id', 'product_id');
    }
}
