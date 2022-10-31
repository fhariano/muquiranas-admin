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
        'order_id',
        'total',
        'order_at',
        'inserted_for'
    ];


    public function bars()
    {
        return $this->hasMany(Bars::class);
    }

    public function ordersItems()
    {
        return $this->belongsToMany(OrdersItems::class);
    }
}
