<?php

namespace App\Http\Controllers\Cake;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\Bars;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Gate;
use App\Models\BarsHistory;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Nette\Utils\Json;

class TransferenciaController extends Controller
{


    public function index()
    {
        if ($this->autenticacaoBar($this->bar_id) == false) {
            return redirect(route('bar.selectBar'));
        } else {
            $statusBar = $this->getStatusBar($this->bar_id);

            if (Gate::allows('transferir_produto', $this->group_id)) {
                return view('transferencia.index')
                    ->with('statusBar', $statusBar)
                    ->with('group_id', $this->group_id);
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function consultaApi()
    {

        try {

            $response = Http::withHeaders([
                'x-cake-token' => '04d1be2fd17ba6769bbf',
                'Accept' => 'application/json'
            ])->get('https://app.cakeerp.com/api/product/all?active=1')['list'];

            $products = json_decode($response);
            $result = array();


            foreach ($products as $key => $value) {

                $dataCategory = $this->categoria($value->category);
                $urlProduct = $this->imgProduct($value->id);
                $res = $this->ifProductExitsCardapio($value->id);

                $result_array = array();

                $result_array['image_url'] = $urlProduct;
                $result_array['category_id'] = $dataCategory[0]->id;
                $result_array['name_category'] = $dataCategory[0]->name;
                $result_array['id'] = $value->id;
                $result_array['ean_erp'] = $value->barcode_ean;
                $result_array['name'] = $value->name;
                $result_array['short_description'] = $value->observation;
                $result_array['quantity'] = $value->stock;
                $result_array['unity'] = $value->model;
                $result_array['price_cost_erp'] = $value->price_cost;
                $result_array['price_sell'] = $value->price_sell;
                $result_array['price_base'] = $value->price_sell;
                $result_array['state'] = $res;
                $result_array['existCardapio'] = ($res === true) ? 1 : 0;

                array_push($result, $result_array);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => 'Ocorreu um erro ao buscar os dados. Por favor, tente novamente mais tarde.'], 500);

        }

        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  \App\Models\Products 
     */
    public function store(Request $request)
    {

        $fieldsProductsCardapio = json_decode($request['data']);



        foreach ($fieldsProductsCardapio as $key => $value) {
            if ($value->ean_erp == '') {
                return 3;
            } else if ($value->category_id != '') {

                $resultExistCategory = $this->ifExistCategory($this->bar_id, $value->category_id, $value->name_category, $this->name_user);
                $idCategory = json_decode($resultExistCategory);

                $this->actionBar();

        
                    $highestOrderProduct = $this->ordenacaoProduct($idCategory->id);
                    $nextOrder = $highestOrderProduct + 1;

                if ($value->existCardapio == 0) {
                    $productData = [
                        'ean_erp' => $value->ean_erp,
                        'name' => $value->name,
                        'category_id' => $idCategory->id,
                        'short_description' => $value->short_description,
                        'unity' => $value->unity,
                        'quantity' => $value->quantity,
                        'price_cost_erp' => $value->price_cost_erp,
                        'price_sell_erp' => $value->price_sell,
                        'price_base' => $value->price_base,
                        'image_url' => $value->image_url,
                        'order' => $nextOrder,
                        'active' => 1,
                        'inserted_for' => Auth::user()->name,
                        'updated_for' => Auth::user()->name,
                    ];
                } else {
                    $productData = [
                        'quantity' => $value->quantity,
                        'price_sell_erp' => $value->price_sell,
                        'price_base' => $value->price_base,
                        'updated_for' => Auth::user()->name,
                    ];
                }

                $productsFields = Products::updateOrCreate(
                    [
                        'erp_id' => $value->id,
                        'bar_id' => $this->bar_id,
                    ],
                    $productData
                );

                $productsFields->save();

            }
        }
        return true;
    }


    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function produto($id)
    {
        try {

            $response = Http::withHeaders([
                'x-cake-token' => '04d1be2fd17ba6769bbf',
                'Accept' => 'application/json'
            ])->get('https://app.cakeerp.com/api/product/all?id=' . $id)['list'];
        } catch (\Throwable $th) {
            return $th;
        }


        return json_decode($response);
    }


    public function categoria($id)
    {
        try {
            $response = Http::withHeaders([
                'x-cake-token' => '04d1be2fd17ba6769bbf',
                'Accept' => 'application/json'
            ])->get('https://app.cakeerp.com/api/product_category/all?id=' . $id);


            $data = json_decode($response['list']);

            if (empty($data)) {
                // retorna um array vazio caso não haja dados disponíveis
                return [];
            }

            return $data;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro ao buscar os dados categoria. Por favor, tente novamente mais tarde.'], 500);
        }
    }

    public function imgProduct($id)
    {
        try {

            $response = Http::withHeaders([
                'x-cake-token' => '04d1be2fd17ba6769bbf',
                'Accept' => 'application/json'
            ])->get('https://app.cakeerp.com/api/product_image/all?id=' . $id)['list'];
        } catch (\Throwable $th) {
            return $th;
        }
        $field = json_decode($response, true);
        $result = empty($field) ? "SEM IMAGEM" : $field["image_url"];

        return $result;
    }



    public function ifProductExitsCardapio($idProduct)
    {

        try {
            $productExist = Products::where([
                'erp_id' => $idProduct,
                'bar_id' => $this->bar_id,
                'active' => 1
            ])
                ->exists();

        } catch (\Throwable $th) {
            return $th;
        }

        return $productExist;
    }

    public function ordenacaoProduct($idCategory)
    {
        $highestOrder = Products::where('category_id', $idCategory)
            ->where('bar_id', $this->bar_id)
            ->where('active',1)
            ->max('order');
        return $highestOrder;

    }

    public function statusProductCardapio($idErp, $idBar)
    {

        try {

            $result = Products::where('erp_id', $idErp)
                ->where('bar_id', $idBar)
                ->pluck('active')
                ->all();
        } catch (\Throwable $th) {
            return $th;
        }

        return $result;

    }

    public function getStatusBar($id)
    {
        try {
            $bar = Bars::find($id);
            $result = $bar->status;
        } catch (\Throwable $th) {
            return $th;
        }

        return $result;
    }

    public function ifExistCategory($idBar, $idCategory, $nameCategory, $nameUser)
    {

        try {
            $categoryExist = Categories::updateOrCreate([
                'bar_id' => $idBar,
                'erp_id' => $idCategory,

            ], [

                'name' => $nameCategory,
                'order' => 1,
                'inserted_for' => $nameUser,
                'updated_for' => $nameUser,

            ]);

            $categoryExist->save();

        } catch (\Throwable $th) {
            return $th;
        }
        return $categoryExist;
    }

    public function actionBar()
    {

        $action = 'Tranferiu Products';
        try {

            $barsHistoryFilds = new BarsHistory();
            $barsHistoryFilds->bar_id = $this->bar_id;
            $barsHistoryFilds->user_id = Auth::user()->id;
            $barsHistoryFilds->name = Auth::user()->name;
            $barsHistoryFilds->inserted_for = Auth::user()->name;
            $barsHistoryFilds->action = $action;
            $barsHistoryFilds->save();

        } catch (\Throwable $th) {
            return $th;
        }

    }
}