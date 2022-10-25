<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\ProductsPromosLists;
use App\Models\PromosLists;
use App\Models\UsersFavorites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
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
        $products = Products::where('products.active', 1)->orderBy('products.order', 'asc')->get();
        // dd($products);
        if ($products->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }
        // return BarResource::collection($products);
        return response()->json([
            "error" => false,
            "message" => "Lista de produtos!",
            "data" => $products,
        ], 200);
    }

    public function show(Request $request)
    {
        $product = Products::where('products.active', 1)
            ->where('products.id', $request->id)
            ->orderBy('products.category_id', 'asc')
            ->orderBy('products.order', 'asc')
            ->get();
        // dd($product);
        if ($product->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }
        // return BarResource::collection($product);
        return response()->json([
            "error" => false,
            "message" => "Categoria por id!",
            "data" => $product,
        ], 200);
    }

    public function barProducts(Request $request)
    {
        // $nowTime = \Carbon\Carbon::now()->addHours(5);
        // $nowTime = \Carbon\Carbon::now()->subHours(2);
        $nowTime = \Carbon\Carbon::now();
        $nowTime = (string) $nowTime->format('H:i:s');
        $bar_id = $request->bar_id;
        $products = Products::where('products.active', 1)
            ->where('products.bar_id', $bar_id)
            ->orderBy('products.category_id', 'asc')
            ->orderBy('products.order', 'asc')
            ->get();
        // dd($products);
        if ($products->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }

        $promo_list = PromosLists::where('promos_lists.bar_id', $bar_id)->where('promos_lists.active', 1)->first();
        // dd($promo_list);
        if ($promo_list) {
            $products_promo_list = ProductsPromosLists::where('products_promos_lists.promos_list_id', $promo_list->id)
                ->where('products_promos_lists.active', 1)
                ->whereRaw("((TIME(hour_start) <= '$nowTime' AND TIME(hour_end) >= '$nowTime'))")
                ->orderBy('products_promos_lists.product_id', 'asc')
                ->orderBy('products_promos_lists.hour_start', 'asc')
                ->get();
            // dd($products_promo_list);

            foreach ($products as $product) {
                $product['promo'] = false;
                $product['promo_price'] = '0.00';
                $product['promo_expire'] = '00:00:00';
                foreach ($products_promo_list as $promos) {
                    if ($product->id == $promos->product_id) {
                        $product['promo'] = true;
                        $product['promo_price'] = $promos->price;
                        $product['promo_expire'] = $promos->hour_end;
                    }
                }
                $product['now_time'] = $nowTime;
            }
        } else {
            foreach ($products as $product) {
                $product['promo'] = false;
                $product['promo_price'] = '0.00';
                $product['promo_expire'] = '00:00:00';
                $product['now_time'] = $nowTime;
            }
        }

        return response()->json([
            "error" => false,
            "message" => "Produtos por bar id!",
            // "data" => ProductResource::collection($products),
            "data" => $products,
        ], 200);
    }

    public function favoritesProducts(Request $request)
    {
        Log::channel('muquiranas')->info("favoritesProducts - barId: " . $request->bar_id . " - UserId: ". $request->user_id);
        $favorites = UsersFavorites::where('users_favorites.bar_id', $request->bar_id)
        ->where('users_favorites.user_id', $request->user_id)
            ->where('users_favorites.isFavorite', true)
            ->orderBy('users_favorites.bar_id', 'asc')
            ->orderBy('users_favorites.user_id', 'asc')
            ->orderBy('users_favorites.product_id', 'asc')
            ->get();
        // dd($favorites);
        if ($favorites->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }
        // return BarResource::collection($favorites);
        return response()->json([
            "error" => false,
            "message" => "Lista de Produtos Favoritos por bar id e user id!",
            "data" => $favorites,
        ], 200);
    }

    public function toggleFavoriteProduct(Request $request)
    {
        Log::channel('muquiranas')->info("toggleFavoriteProduct - barId: " . $request->bar_id . " - UserId: ". $request->user_id);
        $favorite = UsersFavorites::select('id')
            ->where('bar_id', $request->bar_id)
            ->where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();

        if($favorite){
            $favorite->isFavorite = $request->isFavorite;
            $result = $favorite->save();
        } else {
            $result = DB::table('users_favorites')->insert([
                'bar_id' => $request->bar_id,
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'isFavorite' => $request->isFavorite,
            ]);
        }

        return $result;
    }
}
