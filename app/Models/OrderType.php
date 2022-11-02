<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    use HasFactory;
    protected $table ="order_types";
	// protected $primaryKey ="id";
    protected $fillable = ['erp_id','name','inserted_for','created_at','updated_for'];

}
