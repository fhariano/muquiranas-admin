<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarsHistory extends Model
{
    use HasFactory;
    protected $table = "bars_history";
    protected $fillable = ['bar_id', 'user_id', 'name', 'action','inserted_for'];

}

