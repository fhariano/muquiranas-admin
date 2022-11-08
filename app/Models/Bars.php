<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bars extends Model
{
    use HasFactory;

    protected $table ="bars";
    protected $fillable = ['erp_id','name','short_name','address','city_state','cep','image_url','start_at','end_at','order','active','status','inserted_for','order','active','inserted_for','updated_for'];


    public function categories()
    {
        return $this->hasMany(Categories::class);
    }
}
