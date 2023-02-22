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
use App\Models\OrdersItems;
use App\Models\OrdersType;
use App\Models\Products;
use Illuminate\Support\Facades\Redirect;
use PhpParser\ErrorHandler\Throwing;

class HomeController extends Controller
{

    public function index(Request $request)
    {

        if($this->autenticacaoBar($this->bar_id) == false){
            return redirect(route('bar.selectBar'));
        } else {

            $idUser = Auth::user()->id;
            // $qtdBar = count($this->UserIsOwnerOfBar(Auth::user()->id));
    
            // $fieldUserAtual = $this->fieldUser(Auth::user()->id);
    
        
           
                $idBar = $this->bar_id;
                $statusBar = $this->statusBar;

                $resultConsolidado = $this->buscarDadosConsolidados($idBar,1);
                $nameBar = $this->nameBar;
                $fieldsBar = Bars::all(); //corrigir fazer consula que mostrará todos os bares do user logado.
                $groupUser = $this->group_id;
                $categoriesAll = Categories::whereIn('bar_id',[$idBar])->get();
                
                // $this->atualizaSession($fieldUserAtual);
    
                return view('home.home')
                    ->with('idBar', $idBar)
                    ->with('statusBar', $statusBar)
                    ->with('groupUser', $groupUser)
                    ->with('qtdTotalDia', $resultConsolidado['qtdTotalDia'])
                    ->with('receitas', $this->receitasBar)
                    ->with('totalDia', $resultConsolidado['totalDia'])
                    ->with('mediaDia', $resultConsolidado['mediaDia'])
                    // ->with('totalGeral', $resultConsolidado['totalGeral'])
                    ->with('name', $resultConsolidado['name'])
                    ->with('nameBar', $nameBar)
                    ->with('fieldsBar', $fieldsBar)
                    ->with('categoriesAll', $categoriesAll);
        }



     
            // $this->UserIsOwnerOfBar(Auth::user()->id);
            // return $this->selectBar($this->UserIsOwnerOfBar(Auth::user()->id));


        // if ( !empty($this->UserIsOwnerOfBar(Auth::user()->id)  && $qtdBar > 1)){

        // //print_r('Usuário SUPER ADMIN onde é dono de vários bares' );
        // // dd($this->UserIsOwnerOfBar($idUser));

        //     return $this->selectBar($this->UserIsOwnerOfBar($idUser));

        // }else {

        //     print_r('Usuário ADMIN que administra mais varios bares.' );
        //     dd($this->UserMultAdmin(Auth::user()->id)) ;
        //     // dd($this->UserMultAdmin(Auth::user()->id));

        // }


        // 
    }

 

    // public function selectBar($infoBars)
    // {
    //     // return redirect(Session::get($infoBars));

    //     return redirect(route('bar.selectBar', ['infoBars' => $infoBars]));
    // }

    // public function verificacaoDoUsario($id){

    //     // $resultIsOwnerOfBar = UsersBar::where([
    //     //     'user_id' => $id,
    //     //     'is_owner' =>'1'
    //     // ])->get();

    //     // $tam = count($this->UserIsOwnerOfBar($id));

    //     if ( !empty($this->UserIsOwnerOfBar($id))){
    //         //redirecionar o cara com mais de um usuário para view de pergutar qual bar escolher. 
    //         return $this->UserIsOwnerOfBar($id);
    //     }else {

    //         dd($this->UserMultAdmin($id));

    // }



 

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

       $idBar = intval($request->input('idBar'));
       $idCategoria = intval($request->input('idCategoria'));
        try{
              // Chamar função para buscar os dados consolidados
            $consolidadoDados = $this->buscarDadosConsolidados($request->idBar, $request->idCategoria);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro ao buscar os dados consolidados. Por favor, tente novamente mais tarde.'],500);
        }

        return $consolidadoDados;
        

    }

    // public function consolidadoDados($idBar)
    // {
    //     $consolidoDia = OrdersItems::select(
    //         DB::raw('sum(orders_items.quantity) as qtd'),
    //         DB::raw('sum(orders_items.price) as price'),
    //         DB::raw('sum(orders_items.total) as total'),
    //         DB::raw('sum(orders.total) as totalGeral'),
    //         DB::raw('category.name as nameCategoria'),
    //     )
    //         ->join('products as p', 'p.id', '=', 'product_id')
    //         ->leftJoin('categories As category', function ($join) {
    //             $join->on('category.id', '=', 'p.category_id');
    //         })
    //         ->leftJoin('orders As orders', function ($join) {
    //             $join->on('orders.id', '=', 'order_id');
    //         })
    //         //  ->where('category.name','Cervejas')
    //         ->where('category.bar_id', $idBar)
    //         ->where('orders.active', 1)
    //         ->where('category.id', 6)
    //         ->whereNotNull('orders.erp_id')
    //         ->groupBy('nameCategoria')
    //         ->get();



    //     // $dados = json_decode($consolidoDia,true);
    //     // dd($dados);   

    //     $mediaConsolidadoDia = empty($consolidoDia[0]->total) && empty($consolidoDia[0]->qtd) ? '0' : number_format($consolidoDia[0]->total / $consolidoDia[0]->qtd, 2);
    //     $resultConsolidadoDia = array(

    //         "qtdTotalDia" => empty($consolidoDia[0]->qtd) ? '0' : $consolidoDia[0]->qtd,
    //         "totalDia" => empty($consolidoDia[0]->total) ? '0,00' : str_replace('.', ',', $consolidoDia[0]->total),
    //         "mediaDia" => str_replace('.', ',', $mediaConsolidadoDia),
    //         "totalGeral" => empty($consolidoDia[0]->totalGeral) ? '0' : $consolidoDia[0]->totalGeral,
    //         "name" => empty($consolidoDia[0]->nameCategoria) ? 'SEM VENDA' : $consolidoDia[0]->nameCategoria,
    //     );
    //     return $resultConsolidadoDia;

    // }

    public function TotalGeralBar($idBar)
    {
        $totalBar = Orders::select(
            DB::raw('sum(total) as totalBar'),
        )
            ->where('bar_id', $idBar)
            ->get();  
        return $totalBar[0]->totalBar;
    }


    private function buscarDadosConsolidados($idBar, $idCategoria)  //colocar $categoriaBar
    {


        $consolidoDia = OrdersItems::select(
            DB::raw('sum(orders_items.quantity) as qtd'),
            DB::raw('sum(orders_items.price) as price'),
            DB::raw('sum(orders_items.total) as total'),
            // DB::raw('sum(orders.total) as totalGeral'),
            DB::raw('category.name as nameCategoria'),
             DB::raw('category.icon_name as iconCategoria'),
        )
            ->join('products as p', 'p.id', '=', 'product_id')
            ->leftJoin('categories As category', function ($join) {
                $join->on('category.id', '=', 'p.category_id');
            })
            ->leftJoin('orders As orders', function ($join) {
                $join->on('orders.id', '=', 'order_id');
            })
            ->where('orders.bar_id', $idBar)
            ->where('orders.active', 1)
            ->where('category.id', $idCategoria) //idCategoria
            ->whereNull('orders.erp_id')
            ->groupBy('nameCategoria', 'iconCategoria')
            ->first();

       
       
        if (!$consolidoDia) {
           
            return [
                'qtdTotalDia' => 0,
                'totalDia' => 0,
                'mediaDia' => 0,
                'totalGeral' => 0,
                'name' => 'SEM VENDA',
                'iconCategoria' => '',
                'noData' => true,
            ];
        }

        $mediaConsolidadoDia = number_format($consolidoDia->total / $consolidoDia->qtd,2,'.','');
       
        return [
            'qtdTotalDia' => $consolidoDia->qtd,
            'totalDia' => $consolidoDia->total,
            'mediaDia' => $mediaConsolidadoDia,
            'totalGeral' => $this->TotalGeralBar($idBar),
            'name' => $consolidoDia->nameCategoria,
            'iconCategoria' => $consolidoDia->iconCategoria,
            'noData' => false,
            ];
    }
 
    
}