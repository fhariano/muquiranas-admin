<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
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
        ->leftJoin('orders_items', 'orders.id', 'orders_items.order_id')
        ->where('orders.customer_id', $user_id)
        ->where('orders.bar_id', $bar_id)
        ->where('orders.active', 1)
        ->where('bars.active', 1)
        ->orderBy('orders_items.items', 'asc')
        ->toSql();
        dd($orders);
        // if ($orders->isEmpty()) {
        //     return response()->json([
        //         "error" => true,
        //         "message" => "Nenhum registro foi encontrado!",
        //         "data" => [],
        //     ], 404);
        // }
        // return BarResource::collection($orders);
        return response()->json([
            "error" => false,
            "message" => "Lista de orders!",
            "data" => $orders,
        ], 200);
    }

    public function show(Request $request)
    {
        $bar = Orders::where('bars.active', 1)->where('bars.id', $request->id)->orderBy('bars.order', 'asc')->get();
        // dd($bar);
        if ($bar->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }
        // return BarResource::collection($bar);
        return response()->json([
            "error" => false,
            "message" => "Bar por id!",
            "data" => $bar,
        ], 200);
    }
}
