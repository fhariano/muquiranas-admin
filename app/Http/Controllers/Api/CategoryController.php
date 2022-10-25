<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bar;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        $categories = Categories::where('categories.active', 1)->orderBy('categories.order', 'asc')->get();
        // dd($categories);
        if ($categories->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }
        // return BarResource::collection($categories);
        return response()->json([
            "error" => false,
            "message" => "Lista de categorias!",
            "data" => $categories,
        ], 200);
    }

    public function show(Request $request)
    {
        $category = Categories::where('categories.active', 1)
            ->where('categories.id', $request->id)
            ->orderBy('categories.order', 'asc')
            ->get();
        
            // dd($category);
        if ($category->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }
        // return BarResource::collection($category);
        return response()->json([
            "error" => false,
            "message" => "Categoria por id!",
            "data" => $category,
        ], 200);
    }

    public function barCategories(Request $request)
    {
        $categories = Categories::where('categories.active', 1)->where('categories.bar_id', $request->bar_id)->orderBy('categories.order', 'asc')->get();
        // dd($categories);
        if ($categories->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }
        // return BarResource::collection($categories);
        return response()->json([
            "error" => false,
            "message" => "Categorias por bar id!",
            "data" => $categories,
        ], 200);
    }
}
