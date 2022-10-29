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
    public function index()
    {
        $bars = Orders::where('bars.active', 1)->orderBy('bars.order', 'asc')->get();
        // dd($bars);
        if ($bars->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }
        // return BarResource::collection($bars);
        return response()->json([
            "error" => false,
            "message" => "Lista de bares!",
            "data" => $bars,
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
