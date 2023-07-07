<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Models\Bars;
use App\Models\UsersBar; //apagar
use App\Models\Categories;
use App\Models\BarsHistory;
use App\Models\Orders;
use App\Models\PromosLists;
use App\Models\OrdersItems;
use App\Models\Products;
use App\Models\OrdersType;
use Illuminate\Support\Facades\Redirect;
use PhpParser\ErrorHandler\Throwing;
use App\Models\Dashboard;

class HomeController extends Controller
{

    public function index(Request $request)
    {

        if($this->autenticacaoBar($this->bar_id) == false){
            return redirect(route('bar.selectBar'));
        } else {

            $idBar = $this->bar_id;
                $statusBar = $this->statusBar;
                $promoListModel = new PromosLists();

                $nomeDaLista = $promoListModel->listActive($idBar);
                $nameBar = $this->nameBar;
                $fieldsBar = $this->baresUserLogado; //corrigir fazer consula que mostrará todos os bares do user logado.
                $groupUser = $this->group_id;
                $categoriesAll = Categories::whereIn('bar_id',[$idBar])->get();        
                     
                return view('home.home')
                    ->with('idBar', $idBar)
                    ->with('statusBar', $statusBar)
                    ->with('groupUser', $groupUser)
                    ->with('receitas', $this->receitasBar)
                    ->with('nomeDaLista', $nomeDaLista)
                    ->with('nameBar', $nameBar)
                    ->with('fieldsBar', $fieldsBar)
                    ->with('categoriesAll', $categoriesAll);
        }

    }

     public function UserIsOwnerOfBar($idUser)
    {
        $resultIsOwnerOfBar = UsersBar::select(
            DB::raw('users_bars.bar_id as bar_id'),
            DB::raw('users_bars.group_id as group_id'),
            DB::raw('bars.status as statusBar'),
            DB::raw('bars.short_name as nameBar'),
            DB::raw('users_bars.is_owner as DonoBar'),

        )
            ->join('bars as bars', 'bars.id', '=', 'bar_id')
            ->where([
                'user_id' => $idUser,
                'is_owner' => '1',
                'group_id' => '1',
            ])
            ->get();

        return json_decode($resultIsOwnerOfBar);
    }

    public function fieldUser($idUser)
    {
        $resultFieldUser = UsersBar::select(
            DB::raw('users_bars.bar_id as bar_id'),
            DB::raw('users_bars.group_id as group_id'),
            DB::raw('bars.status as statusBar'),
            DB::raw('bars.short_name as nameBar'),
            DB::raw('users_bars.is_owner as is_owner'),
        )
            ->join('bars as bars', 'bars.id', '=', 'bar_id')
            ->where([
                'user_id' => $idUser,
            ])
            ->get();

        return json_decode($resultFieldUser);
    }

    public function listActive(){
        $resultQuery =  PromosLists::select(
            DB::raw('name as name')
        )  
        ->where('active', 1)
        ->where('status', 1)
        ->where('bar_id', $this->bar_id)
        ->get();
        
        if (!$resultQuery->isEmpty()) {
            $fields = $resultQuery->toArray();
            return $fields[0]['name'];
        } else {
            return 'Nenhuma';
        }
    }


    public function UserMultAdmin($idUser)
    {

        $resultMultAdmin = UsersBar::select(
            DB::raw('users_bars.bar_id as bar_id'),
            DB::raw('users_bars.group_id as group_id'),
            DB::raw('bars.status as statusBar'),
            DB::raw('bars.short_name as nameBar'),

        )
            ->join('bars as bars', 'bars.id', '=', 'bar_id')
            ->where([
                'user_id' => $idUser,
                'is_owner' => '1',
                'group_id' => '2',
            ])
            ->get();

        return json_decode($resultMultAdmin);
      
    }

    public function requestConsolidadoDados(Request $request){

          try{
              // Chamar função para buscar os dados consolidados
              $dashboardModel = new Dashboard();
              $consolidadoDados = $dashboardModel->buscarDadosConsolidados($request->idBar, $request->idCategoria);
      
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro ao buscar os dados consolidados. Por favor, tente novamente mais tarde.'],500);
        }

        return $consolidadoDados;
        
    }
 
    
}