<?php

namespace App\Http\Controllers;

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
        

    }

   



    public function buscarDadosConsolidados(int $barId, int $categoryId):array  //colocar $categoriaBar
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
