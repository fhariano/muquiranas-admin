<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $model;
    protected $identify;
    protected $apikey;

    public function __construct(Orders $order)
    {
        $this->model = $order;
        $this->identify = request()->header('Identify');
        $this->apikey = request()->header('apikey');
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
            ->select('orders.*')
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
                    'p.marca',
                    'p.unity',
                    'p.image_url',
                    'oItems.quantity',
                    'oItems.price',
                    'oItems.total'
                )
                ->leftJoin('products AS p', 'oItems.product_id', 'p.id')
                ->where('order_id', $order->id)
                ->orderBy('oItems.item', 'asc')
                ->get();

            foreach ($items as $item) {
                $order->items[] = $item;
            }
        }

        return response()->json([
            "error" => false,
            "message" => "Lista de orders!",
            "data" => $orders,
        ], 200);
    }

    public function show($order_num)
    {
        $order = DB::table('orders')
            ->select('orders.*')
            ->leftJoin('bars', 'orders.bar_id', 'bars.id')
            ->where('orders.order_num', $order_num)
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
                    'p.marca',
                    'p.unity',
                    'p.image_url',
                    'oItems.quantity',
                    'oItems.price',
                    'oItems.total'
                )
                ->leftJoin('products AS p', 'oItems.product_id', 'p.id')
                ->where('order_id', $order->id)
                ->orderBy('oItems.item', 'asc')
                ->get();

            foreach ($items as $item) {
                $order->items[] = $item;
            }
        }

        return response()->json([
            "error" => false,
            "message" => "Order by id!",
            "data" => $order,
        ], 200);
    }

    public function store(StoreOrder $request)
    {
        Log::channel('muquiranas')->info('request1:' . print_r($request->all(), true));
        Request()->attributes->add(['apikey' => $this->apikey]);
        Log::channel('muquiranas')->info('request2:' . print_r($request->all(), true));
        // $data = $request->validated();

        Log::channel('muquiranas')->info('user identify:' . $this->identify);
        // Log::channel('muquiranas')->info('data:' . print_r($data, true));
        
        // $order = $this->model->create([
        //     'bar_id' => $data['bar_id'],
        //     'customer_id' => $data['customer_id'],
        //     'order_num' => $data['order_num'],
        //     'total' => $data['total'],
        //     'order_at' => $data['order_at'],
        //     'inserted_for' => $data['inserted_for'],
        // ]);

        // $items = $order->Products()->sync($data['items']);

        return response()->json([
            "error" => false,
            "message" => "Created Order!",
            "data" => []
        ], 200);
    }
}
