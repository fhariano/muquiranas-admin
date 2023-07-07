<?php

use App\Http\Controllers\BarsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PromosListController;
use App\Http\Controllers\ProductsPromosListController;
use App\Models\Products;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use App\Http\Controllers\Api\OrderController;
use App\Jobs\SyncVendasJob;
use PhpParser\Node\Stmt\Return_;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
|
*/

Route::get('/', function () {
    $idbarSelecionado = session()->get('bar_id');
    if(autenticacaoBar($idbarSelecionado) == false & session()->get('group_id') != 6 ){
        return redirect(route('bar.selectBar'));
    }else{
        return redirect('/home');
    }  
    
})->middleware('auth');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/getOrderForErp/{idBarUsuarioLogado}', [OrderController::class, 'retornaOrdersParaApi'])->name('getOrderForErp')->middleware('auth');
Route::get('send-Order-to-erp', function(){
        $json = '{
        "order_type": 1,
        "fiscal_operation": 24052,
        "date_order": "2023-05-31",
        "date_sell": "2023-05-31",
        "customer": 9285552,
        "payment_form": 59702,
        "seller": 45574,
        "delivery_time": "2023-05-31"
    }';
    SyncVendasJob::dispatch($json);

    return 'DADOS ENVIADOS PARA O ERP COM SUCESSSO. ';

});
Route::post('/home/requestConsolidadoDados', [HomeController::class, 'requestConsolidadoDados'])->name('requestConsolidadoDados');

// Route::get('/categorias/create', [CategoriesController::class, 'create'])->name('categorias.create');


Route::name('transferencia.')->middleware('auth')->prefix('/transferencia')->controller(App\Http\Controllers\Cake\TransferenciaController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/consultaApi', 'consultaApi');
    Route::post('/store', 'store')->name('store');
});

Route::name('cardapio.')->middleware('auth')->prefix('/cardapio')->controller(ProductsController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/show', 'show')->name('show');
    Route::post('/store', 'store')->name('store');
    Route::post('/edit/{id}', 'edit')->name('edit');
    Route::put('/update', 'update')->name('update');
    Route::put('/delete', 'destroy')->name('delete');
    Route::get('/categories', 'getCategories')->name('getCategories');
    Route::get('/getProductsFromCategory/{idCategory}', 'getProductsCategory')->name('getProductsCategory');
});

Route::name('categorias.')->middleware('auth')->prefix('/categorias')->controller(CategoriesController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/show', 'show')->name('show');
    Route::put('/update', 'update')->name('update');
    Route::put('/disableCategory', 'disableCategory')->name('disableCategory');
    Route::post('/getCategories', 'getCategories')->name('getCategories');
});

Route::name('listas.')->middleware('auth')->prefix('/listas')->controller(PromosListController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'create')->name('create');
    Route::get('/show', 'show')->name('show');
    Route::post('/store', 'store')->name('store');
    Route::post('/edit/{id}', 'edit')->name('edit');
    Route::put('/update', 'update')->name('update');
    Route::post('/delete', 'delete')->name('delete');
    Route::put('/disableListPromo', 'disableListPromo')->name('disableListPromo');
    Route::put('/destroyListPromo', 'destroyListPromo')->name('destroyListPromo');
});



Route::name('dashboard.')->middleware('auth')->prefix('/dash')->group(function () {
    Route::get('/getdataEstoqueFinal', [BarsController::class, 'getDataEstoqueFinal'])->name('getDataEstoqueFinal');
    // Outras rotas do dashboard...
});


Route::name('bar.')->middleware('auth')->prefix('/bar')->controller(BarsController::class)->group(function() {

    Route::any('/selectBar', 'selectBar')->name('selectBar');
    Route::post('/requestSelectBar','requestSelectBar')->name('requestSelectBar');
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'create')->name('create');
    Route::get('/show', 'show')->name('show');
    Route::post('/store', 'store')->name('store');
    Route::put('/update','update')->name('update');
    Route::put('/destroy','destroy')->name('destroy');
    Route::post('/updateStatusBar','updateStatusBar')->name('updateStatusBar');
    Route::post('/requestValorReceita','requestValorReceita')->name('requestValorReceita'); 
  

});

Route::name('promocoes.')->middleware('auth')->prefix('/promocoes')->controller(ProductsPromosListController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{idLista}', 'show')->name('show');
    Route::post('/store', 'store')->name('store');
    Route::post('/edit/{id}', 'edit')->name('edit');
    Route::put('/update', 'update')->name('update');
    Route::put('/delete', 'destroy')->name('delete');
    Route::get('/list/{idList}/product/{idProduct}', 'getProductsList')->name('getProductsList');
});


function autenticacaoBar($idBar){
    return isset($idBar);   
}