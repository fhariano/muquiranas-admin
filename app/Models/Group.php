<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table ="groups";

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

}
