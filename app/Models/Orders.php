<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table ="orders";

    public function bars()
    {
        return $this->hasMany(Bars::class);
    }

    public function users()
    {
        return $this->hasMany(Users::class);
    }
}
