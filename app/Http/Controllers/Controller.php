<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{

    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected  $bar_id;
    protected  $group_id;
    protected  $name_user;
    
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $fieldsUser = session()->all(); 
            $this->bar_id = $fieldsUser['bar_id'] ;
            $this->group_id = $fieldsUser['group_id'];
            $this->name_user = Auth::user()->name;
            return $next($request);
        });
    }

}
