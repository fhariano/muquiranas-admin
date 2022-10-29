<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

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
        $orders = Orders::with('bars')
        ->where('bars.active', 1)
        ->where('orders.costumer_id', $user_id)
        ->where('borders.ar_id', $bar_id)
        ->orderBy('orders.items', 'asc')->get();
        // dd($orders);
        if ($orders->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }
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
