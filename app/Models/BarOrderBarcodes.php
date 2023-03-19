<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarOrderBarcodes extends Model
{
    use HasFactory;

    protected $table = "bar_order_barcodes";

    protected $fillable = ['bar_id', 'order_id', 'product_id', 'user_identify', 'barcode', 'validate', 'used_at', 'active'];

    public function bars()
    {
        return $this->belongsToMany(Orders::class, 'bars', 'bar_id', );
    }

    public function orders()
    {
        return $this->belongsToMany(Orders::class, 'orders', 'order_id', );
    }

    public function products()
    {
        return $this->belongsToMany(Orders::class, 'products', 'product_id', );
    }
}
