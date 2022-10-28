<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PromosLists extends Model
{
    use HasFactory;

    protected $table = "promos_lists";
    // protected $primaryKey = "id";
    protected $fillable = ['bar_id','name','active', 'inserted_for', 'updated_for']; //inserted_for and updated_for está default "Murilo_temp" no banco.
    // protected $guarded = [];

    //Verifica se Existe um nome igual antes de inserir no banco. 
    public function bars() {
        return $this->belongsTo(Bars::class);
    } 
   
    public function existName($data, $bar_id)
    {
        try {
            $existName = DB::table('promos_lists')
            ->where('name', $data)
            ->where('bar_id', $bar_id)
            ->exists();
        } catch (\Throwable $th) {
            return $th;
        }
        return $existName;
    }

    use HasFactory;
}

