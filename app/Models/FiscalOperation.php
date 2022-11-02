<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscalOperation extends Model
{
    use HasFactory;

    protected $table ="fiscal_operations";
	// protected $primaryKey ="id";
    protected $fillable = ['erp_id','name','inserted_for','created_at','updated_for'];

}
