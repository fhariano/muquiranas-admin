<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarOrderBarcodes extends Model
{
    use HasFactory;

    protected $table = "bar_order_barcodes";

    protected $fillable = ['bar_id', 'order_id', 'user_identify', 'barcode', 'validate', 'used_at', 'active'];

    public function bars()
    {
        return $this->belongsTo(Bars::class);
    }

    public function orders()
    {
        return $this->belongsTo(Orders::class);
    }
}
