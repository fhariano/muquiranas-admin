<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bars extends Model
{
    use HasFactory;

    protected $table ="bars";

    public function categories()
    {
        return $this->hasMany(Categories::class);
    }
}
