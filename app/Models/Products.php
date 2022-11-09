<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table ="products";
	// protected $primaryKey ="id";
    protected $fillable = ['bar_id','erp_id','image_url','category_id','ean_erp','name','short_name','short_description','unity','quantity','price_cost_erp','price_sell_erp','price_base','order','active','inserted_for','updated_for'];

    public function Orders()
    {
        return $this->belongsToMany(Orders::class, 'orders_items');
    }

}
