<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrdersItems;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;

class Dashboard extends Model
{
    use HasFactory;


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

    public function TotalGeralBar($idBar)
    {
        $totalBar = Orders::select(
            DB::raw('sum(total) as totalBar'),
        )
            ->where('bar_id', $idBar)
            ->get();  
        return $totalBar[0]->totalBar;
    }

    public static function getDataByBarId($barId)
    {
        try {
            $data = DB::table('products as p')
                ->select('p.name AS product_name', DB::raw('SUM(p.quantity) AS total_quantity'),
                    'c.name AS category_name',
                    'c.icon_name AS category_icon'
                )
                ->join('categories as c', 'c.id', '=', 'p.category_id')
                ->where('p.bar_id', $barId)
                ->where('p.active', 1)
                ->groupBy('c.name', 'c.icon_name', 'p.name')
                ->orderBy('category_name', 'asc') 
                ->orderBy('total_quantity', 'asc')
                ->get();

            return $data;
        } catch (\Exception $e) {
            // Tratar a exceção aqui
            return [];
        }
    }


    public static function generateProductConsumptionChart(int $barId)
{
    $data = DB::table('categories')
        ->select('categories.name AS category_name', 'products.short_name AS product_name', 'orders_items.quantity AS total_quantity')
        ->join('products', 'categories.id', '=', 'products.category_id')
        ->join('orders_items', function ($join) {
            $join->on('products.id', '=', 'orders_items.product_id')
                ->where('orders_items.quantity', '=', function ($query) {
                    $query->select(DB::raw('MAX(quantity)'))
                        ->from('orders_items')
                        ->whereColumn('products.id', '=', 'orders_items.product_id');
                });
        })
        ->where('products.bar_id', $barId)
        ->where('products.active', 1)
        ->groupBy('categories.name', 'products.short_name', 'orders_items.quantity')
        ->orderBy('categories.name')
        ->get();

    return $data;
}

    

    


}
