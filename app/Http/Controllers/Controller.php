<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

use App\Models\Bars;

class Controller extends BaseController
{

    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected  $bar_id;
    protected  $group_id;
    protected  $name_user;
    protected  $statusBar;
    protected  $nameBar;
    
    public function __construct()
    {
        
        $this->middleware(function ($request, $next) {
            $this->bar_id = session()->get('bar_id');
            $this->group_id = session()->get('group_id');
            $this->nameBar = session()->get('nameBar');
            $this->statusBar = $this->getStatusBar($this->bar_id);
            $this->name_user = Auth::user()->name;
            return $next($request);
        });
    }

    public function getStatusBar($id)
    {
        try {
            $bar = Bars::find($id);
            $result = $bar->status;
        } catch (\Throwable $th) {
            return $th;
        }

        return $result;
    }

}
