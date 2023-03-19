<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarOrderBarcodes extends Model
{
    use HasFactory;

    protected $table = "bar_order_barcodes";

    protected $fillable = ['bar_id', 'order_id', 'product_id', 'user_identify', 'barcode', 'validate', 'used_at', 'active'];
}
