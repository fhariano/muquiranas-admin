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
                
                //Retirar esses dados que vão para view
    
                return view('home.home')
                    ->with('idBar', $idBar)
                    ->with('statusBar', $statusBar)
                    ->with('groupUser', $groupUser)
                    ->with('qtdTotalDia', $resultConsolidado['qtdTotalDia'])
                    ->with('receitas', $this->receitasBar)
                    ->with('totalDia', $resultConsolidado['totalDia'])
                    ->with('mediaDia', $resultConsolidado['mediaDia'])
                    // ->with('totalGeral', $resultConsolidado['totalGeral'])
                    ->with('name', $resultConsolidado['category_name'])
                    ->with('nameBar', $nameBar)
                    ->with('fieldsBar', $fieldsBar)
                    ->with('categoriesAll', $categoriesAll);
        }



     
            // $this->UserIsOwnerOfBar(Auth::user()->id);
            // return $this->selectBar($this->UserIsOwnerOfBar(Auth::user()->id));


        // if ( !empty($this->UserIsOwnerOfBar(Auth::user()->id)  && $qtdBar > 1)){

        // //print_r('Usuário SUPER ADMIN onde é dono de vários bares' );
        

        //     return $this->selectBar($this->UserIsOwnerOfBar($idUser));

        // }else {

        //     print_r('Usuário ADMIN que administra mais varios bares.' );
  
   

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
    //     $consolidadoDia = OrdersItems::select(
    //         DB::raw('sum(orders_items.quantity) as qtd'),
    //         DB::raw('sum(orders_items.price) as price'),
    //         DB::raw('sum(orders_items.total) as total'),
    //         DB::raw('sum(orders.total) as totalGeral'),
    //         DB::raw('category.name as category_name'),
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
    //         ->groupBy('category_name')
    //         ->get();



    //     // $dados = json_decode($consolidadoDia,true);
    //     // dd($dados);   

    //     $mediaConsolidadoDia = empty($consolidadoDia[0]->total) && empty($consolidadoDia[0]->qtd) ? '0' : number_format($consolidadoDia[0]->total / $consolidadoDia[0]->qtd, 2);
    //     $resultConsolidadoDia = array(

    //         "qtdTotalDia" => empty($consolidadoDia[0]->qtd) ? '0' : $consolidadoDia[0]->qtd,
    //         "totalDia" => empty($consolidadoDia[0]->total) ? '0,00' : str_replace('.', ',', $consolidadoDia[0]->total),
    //         "mediaDia" => str_replace('.', ',', $mediaConsolidadoDia),
    //         "totalGeral" => empty($consolidadoDia[0]->totalGeral) ? '0' : $consolidadoDia[0]->totalGeral,
    //         "name" => empty($consolidadoDia[0]->category_name) ? 'SEM VENDA' : $consolidadoDia[0]->category_name,
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


    private function buscarDadosConsolidados(int $barId, int $categoryId):array  //colocar $categoriaBar
    {
        $consolidadoDia = OrdersItems::select(
            DB::raw('sum(orders_items.quantity) as quantity'),
            DB::raw('sum(orders_items.price) as price'),
            DB::raw('sum(orders_items.total) as total'),
            DB::raw('category.name as category_name'),
            DB::raw('category.icon_name as category_icon'),
            DB::raw('p.short_name as product_name'),
            DB::raw('p.image_url as product_image'),
        )
            ->join('products as p', 'p.id', '=', 'product_id')
            ->leftJoin('categories As category', function ($join) {
                $join->on('category.id', '=', 'p.category_id');
            })
            ->leftJoin('orders As orders', function ($join) {
                $join->on('orders.id', '=', 'order_id');
            })
            ->where('orders.bar_id', $barId)
            ->where('orders.active', true)
            ->where('category.id', $categoryId)
            ->whereNull('orders.erp_id')
            ->groupBy('category_name', 'category_icon','product_name','product_image')
            ->orderByDesc('quantity')
            ->get();

       
       
        if ($consolidadoDia->isEmpty()) {
           
            return [
                'product_name' => [],
                'qtdTotalDia' => 0,
                'totalDia' => 0,
                'mediaDia' => 0,
                'totalGeral' => 0,
                'category_name' => 'SEM VENDA',
                'category_icon' => '',
                'noData' => true,
            ];
        }

       //Dados da tabela dos produtos
        $fieldsProducts = $consolidadoDia->map(function ($consolidado) {
            $mediaPorProduto = number_format($consolidado->total / $consolidado->quantity,2,'.','');
            return [
                'product_name' => $consolidado->product_name,
                'quantity' => $consolidado->quantity,
                'price' => $consolidado->price,
                'total' => $consolidado->total,
                'product_image' => $consolidado->product_image,
                'mediaPorProduto' =>$mediaPorProduto,
            ];
        });
        
        //Dados consolidado dos cards
        $fieldsCards = [];
        $qtdTotalDia = 0;
        $totalDia = 0;
       
        foreach ($consolidadoDia as $consolidado) {
            $qtdTotalDia += $consolidado->quantity;
            $totalDia += $consolidado->total;         
                
        }

        $mediaConsolidadoDia = number_format($totalDia / $qtdTotalDia,2,'.','');
        
        return [
            'fieldsProducts' => $fieldsProducts,
            'qtdTotalDia' => $qtdTotalDia,
            'totalDia' => $totalDia,
            'mediaDia' => $mediaConsolidadoDia,
            'totalGeral' => $this->TotalGeralBar($barId),
            'category_name' => $consolidadoDia[0]->category_name,
            'category_icon' => $consolidadoDia[0]->category_icon,
            'noData' => false,
        ];

    }
 
    
}