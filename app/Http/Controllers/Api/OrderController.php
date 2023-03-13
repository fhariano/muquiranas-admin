<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder;
use App\Models\Orders;
use App\Models\ProductsPromosLists;
use App\Models\PromosLists;
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
        request()->request->add(['apikey' => $this->apikey]);
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
        $data = $request->validated();

        // Log::channel('muquiranas')->info('ORDER - user identify:' . $this->identify);
        // Log::channel('muquiranas')->info('ORDER - data: ' . print_r($data, true));

        // Primeiro: Checar itens do carrinho!
        // - quantidade do item em estoque
        // Segundo: Checar itens em promoção
        // - promoção ainda é válida?
        $items = [];
        $items = $data['items'];

        for ($i = 0; $i < count($items); $i++) {
            // Log::channel('muquiranas')->info('ORDER item:' . print_r($items[$i], true));

            $result = DB::table('bars as b')
                ->leftJoin('products as p', 'b.id', '=', 'p.bar_id')
                ->where('b.id', $data['bar_id'])
                ->where('p.id', $items[$i]['product_id'])
                ->select('p.*')
                ->first();

            // Log::channel('muquiranas')->info('ORDER estoque result  :' . print_r($result, true));
            Log::channel('muquiranas')->info('ORDER estoque product :' . $result->quantity);
            Log::channel('muquiranas')->info('ORDER estoque minimo  :' . config('microservices.minStock'));

            // Produto abaixo do estoque mínimo retorna erro
            if ($result->quantity < config('microservices.minStock')) {
                return response()->json([
                    "error" => true,
                    "message" => "O produto {$result->short_name}\nestá Sem Estoque!",
                    "data" => []
                ], 422);
            }

            $nowTime = \Carbon\Carbon::now()->addMinutes(config('microservices.stopPromo'));
            $nowTime = (string) $nowTime->format('H:i:s');
            Log::channel('muquiranas')->info('ORDER nowTime:' . $nowTime . ' - promo product: ' . $items[$i]['promo_expire']);

            $promo_list = PromosLists::where('bar_id', $data['bar_id'])->where('active', 1)->first();
            // Log::channel('muquiranas')->info('ORDER promo list  :' . print_r($promo_list, true));

            if ($promo_list) {
                $stopPromo = strtotime($nowTime) > strtotime($items[$i]['promo_expire']);
                Log::channel('muquiranas')->info('ORDER stop promo:' . $stopPromo);

                if ($stopPromo) {
                    return response()->json([
                        "error" => true,
                        "message" => "O produto {$result->short_name}\nnão está mais com este preço!",
                        "data" => []
                    ], 422);
                }
            }
        }

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
