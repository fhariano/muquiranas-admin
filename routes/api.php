<?php

use App\Http\Controllers\Api\BarController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/bars/{id}', [BarController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['chk_user_auth'])->group(function () {
    // API
    Route::get('/bars', [BarController::class, 'index']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::get('/categories/bar/{bar_id}', [CategoryController::class, 'barCategories']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/products/bar/{bar_id}', [ProductController::class, 'barProducts']);

    Route::get('/products/favorites/bar/{bar_id}/user/{user_id}', [ProductController::class, 'favoritesProducts']);
    Route::put('/products/favorites/bar/{bar_id}/user/{user_id}', [ProductController::class, 'toggleFavoriteProduct']);

    Route::get('/orders/{order_id}', [OrderController::class, 'show']);

    Route::get('/orders/user/{user_id}/bar/{bar_id}', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
});
