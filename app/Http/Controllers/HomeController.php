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
        $group = Auth::user()->group_id; 
        $idBar = Auth::user()->bar_id;
        // $statusBar = $this->getStatusBar($idBar);
       $resultConsolidado = $this->consolidadoDados($idBar);
       
        return view('home.home')
            // ->with('statusBar', $statusBar)
            ->with('group', $group)
            ->with('qtdTotalDia', $resultConsolidado['qtdTotalDia'])
            ->with('totalDia', $resultConsolidado['totalDia'])
            ->with('mediaDia', $resultConsolidado['mediaDia'])
            ->with('totalGeral', $resultConsolidado['totalGeral']);
  
    }


    public function consolidadoDados($idBar)
    {            
        $consolidoDia = OrdersItems::select(
            DB::raw( 'sum(orders_items.quantity) as qtd'),
            DB::raw('sum(orders_items.price) as price'),
            DB::raw('sum(orders_items.total) as total'),
            DB::raw('sum(orders.total) as totalGeral'),
        )
        ->join('products as p', 'p.id' ,'=' , 'product_id')
        ->leftJoin('categories As ctg' , function($join){
            $join->on('ctg.id', '=', 'p.category_id');
        })
        ->leftJoin('orders As orders' , function($join){
            $join->on('orders.id', '=', 'order_id');
        })
        ->where('ctg.name', 'Cervejas')
        ->where('ctg.bar_id',$idBar)
        ->where('orders.billed',0)
        ->where('orders.active',1)
        ->first();

        $mediaConsolidadoDia = empty($consolidoDia->total) && empty($consolidoDia->qtd) ? '0' : number_format($consolidoDia->total / $consolidoDia->qtd, 2);
        $resultConsolidadoDia = array(
         
            "qtdTotalDia" => empty($consolidoDia->qtd) ? '0'  : $consolidoDia->qtd ,
            "totalDia" => empty($consolidoDia->total) ?  '0,00'  : str_replace('.',',',$consolidoDia->total),
            "mediaDia" => str_replace('.',',',$mediaConsolidadoDia),
            "totalGeral" => empty($consolidoDia->totalGeral) ? '0'  : $consolidoDia->totalGeral ,
          );
        return $resultConsolidadoDia;

    }

 


}
