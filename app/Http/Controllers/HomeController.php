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
use App\Models\BarsHistory;
use App\Models\Orders;
use App\Models\OrdersItems;
use App\Models\OrdersType;
use App\Models\Products;


class HomeController extends Controller
{   
    


    public function index(Request $request)
    {
        // $group = Auth::user()->group_id; 
        $idBar = Auth::user()->bar_id;
    //    $statusBar = $this->getStatusBar($idBar);
       $resultConsolidado = $this->consolidadoDados($idBar);
       dd($resultConsolidado);
        // return view('home.home')
        //     ->with('statusBar', $statusBar)
        //     ->with('group', $group)
        //     ->with('resultConsolidado', $resultConsolidado);
  
    }


    public function consolidadoDados($idBar)
    {            
        $consolidoDia = OrdersItems::select(
            DB::raw( 'sum(orders_items.quantity) as qtd'),
            DB::raw('sum(orders_items.price) as price'),
            DB::raw('sum(orders_items.total) as total'),
        )
        ->join('products as p', 'p.id' ,'=' , 'product_id')
        ->leftJoin('categories As ctg' , function($join){
            $join->on('ctg.id', '=', 'p.category_id');
        })
        ->where('ctg.name', 'Cervejas')
        ->where('ctg.bar_id',$idBar)
        ->first();
        $mediaConsolidadoDia = $consolidoDia->total / $consolidoDia->qtd; 
        
        

        return $consolidoDia;

    }

    public function updateStatusBar(Request $request, Bars $Bars) 
    {
        $idBar = Auth::user()->bar_id;

        try {
            $this->actionBar($request->status);
            $barFields = Bars::find($idBar);
            $barFields->status = $request->status;
            $barFields->save();
        
          
        }catch (\Throwable $th){
            return $th;
        }
          return true; 
    }

    public function actionBar($action){

        if($action === '1'){
            $action = 'Abriu Bar';
        }else{
            $action = 'Fechou Bar';
        }

        try {

            $barsHistoryFilds = new BarsHistory();
            $barsHistoryFilds->bar_id = Auth::user()->bar_id;
            $barsHistoryFilds->user_id = Auth::user()->id;
            $barsHistoryFilds->name = Auth::user()->name;
            $barsHistoryFilds->inserted_for = Auth::user()->name;
            $barsHistoryFilds->action = $action;
            $barsHistoryFilds->save();

        }catch(\Throwable $th){
            return $th;
        }

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
