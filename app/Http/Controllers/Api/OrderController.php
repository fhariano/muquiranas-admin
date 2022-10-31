<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $model;

    public function __construct(Orders $order)
    {
        $this->model = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($user_id, $bar_id)
    {
        $orders = DB::table('orders')
            ->leftJoin('bars', 'orders.bar_id', 'bars.id')
            ->where('orders.customer_id', $user_id)
            ->where('orders.bar_id', $bar_id)
            ->where('orders.active', 1)
            ->where('bars.active', 1)
            ->orderBy('orders.id', 'desc')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }

        foreach ($orders as $order) {
            $items = DB::table('orders_items AS oItems')
                ->select(
                    'oItems.order_id',
                    'oItems.item',
                    'oItems.product_id',
                    'p.erp_id',
                    'p.short_name',
                    'p.short_description',
                    'p.unity',
                    'oItems.quantity',
                    'oItems.price',
                    'oItems.total'
                )
                ->leftJoin('products AS p', 'oItems.product_id', 'p.id')
                ->where('order_id', $order->order_id)
                ->orderBy('oItems.item', 'asc')
                ->get();

            foreach ($items as $item) {
                $order->products[] = $item;
            }
        }

        return response()->json([
            "error" => false,
            "message" => "Lista de orders!",
            "data" => $orders,
        ], 200);
    }

    public function show($order_id)
    {
        $order = DB::table('orders')
            ->leftJoin('bars', 'orders.bar_id', 'bars.id')
            ->where('orders.order_id', $order_id)
            ->where('orders.active', 1)
            ->where('bars.active', 1)
            ->orderBy('orders.id', 'desc')
            ->get();

        if ($order->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }

        foreach ($order as $order) {
            $items = DB::table('orders_items AS oItems')
                ->select(
                    'oItems.order_id',
                    'oItems.item',
                    'oItems.product_id',
                    'p.erp_id',
                    'p.short_name',
                    'p.short_description',
                    'p.unity',
                    'oItems.quantity',
                    'oItems.price',
                    'oItems.total'
                )
                ->leftJoin('products AS p', 'oItems.product_id', 'p.id')
                ->where('order_id', $order->order_id)
                ->orderBy('oItems.item', 'asc')
                ->get();

            foreach ($items as $item) {
                $order->products[] = $item;
            }
        }

        return response()->json([
            "error" => false,
            "message" => "Order by id!",
            "data" => $order,
        ], 200);
    }

    public function store(StoreOrder $request){
        $data = $request->validated();

        $order = $this->model->create([
            'bar_id' => $data['bar_id'],
            'customer_id' => $data['customer_id'],
            'order_id' => $data['order_id'],
            'total' => $data['total'],
            'order_at' => $data['order_at'],
            'inserted_for' => $data['inserted_for'],
        ]);

        $order->ordersItems($data['products']);

        return response()->json([
            "error" => false,
            "message" => "Created Order!",
            "data" => []
        ], 200);

    }
}
