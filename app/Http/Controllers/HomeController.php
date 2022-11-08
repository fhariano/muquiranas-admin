<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Models\Bars;


class HomeController extends Controller
{   
    


    public function index(Request $request)
    {
        $group = Auth::user()->group_id; 
        $idBar = Auth::user()->bar_id;
       $statusBar = $this->getStatusBar($idBar);
        return view('home.home')
            ->with('statusBar', $statusBar)
            ->with('group', $group);
  
    }

    public function updateStatusBar(Request $request, Bars $Bars) 
    {
        $idBar = Auth::user()->bar_id;

        try {
            $barFields = Bars::find($idBar);
            $barFields->status = $request->status;
            $barFields->save();
            
        }catch (\Throwable $th){
            return $th;
        }
          return $resultUpStatusBar = true; 
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
