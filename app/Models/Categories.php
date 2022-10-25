<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{

	Use HasFactory;

    protected $table ="categories";
	// protected $primaryKey ="id";
	protected $fillable = ['bar_id','id_erp','name','icon_data','icon_name','order','active','inserted_for','updated_for'];

	public function bars() {
        return $this->belongsTo(Bars::class);
    }   
}
