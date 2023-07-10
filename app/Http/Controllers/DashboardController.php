<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Models\Dashboard;
use App\Models\Bars;
use App\Models\UsersBar; //apagar
use App\Models\Categories;
use App\Models\BarsHistory;
use App\Models\Orders;
use App\Models\PromosLists;
use App\Models\OrdersItems;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if($this->autenticacaoBar($this->bar_id) == false){
            return redirect(route('bar.selectBar'));
        }else{
        
            if (Gate::allows('visualizar_dash', $this->group_id)) {
                return view('dash.index');
             
            } 
        }

        

    }

    public function getDataEstoqueFinal()
    {
        $barId = $this->bar_id; // Defina o valor adequado para o ID do bar

        $data = Dashboard::getDataByBarId($barId);
        return $data;

        // Resto do código para manipular os dados
    }

  
}
