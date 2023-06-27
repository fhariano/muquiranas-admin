<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersBar extends Model
{
    use HasFactory;
 
    protected $table ="users_bars";
    protected $fillable = ['user_id','bar_id','group_id','is_owner','inserted_for','updated_for','updated_at'];
}



