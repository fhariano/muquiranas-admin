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
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Nette\Utils\Json;

class TransferenciaController extends Controller
{
   
   

    public function index()
    {
        
        // $group = Auth::user()->group_id; 

      
        $statusBar = $this->getStatusBar($this->bar_id);
      
        return  view('transferencia.index')
            ->with('statusBar', $statusBar)
            ->with('group_id', $this->group_id);
            

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
                $res= $this->ifProductExitsCardapio($value->id);
                $result_array = array();

                $result_array['image_url'] = $urlProduct;
                $result_array['category_id'] = $dataCategory[0]->id;
                $result_array['name_category'] = $dataCategory[0]->name;
                $result_array['id'] = $value->id;
                $result_array['ean_erp'] = $value->barcode_ean;
                $result_array['name'] = $value->name;
                $result_array['short_name'] = $value->observation;
                $result_array['short_description'] = $value->technical_specifications;
                $result_array['quantity'] = $value->stock;
                $result_array['unity'] =  $value->model;
                $result_array['price_cost_erp'] = $value->price_cost;
                $result_array['price_sell'] = $value->price_sell;
                $result_array['price_base'] = $value->price_sell;
                $result_array['state'] =  $res;

                array_push($result, $result_array);
            }
        } catch (\Throwable $th) {

            return  $th;
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
            } else if ($value->category_id  != '') {
             
                $resultExistCategory = $this->ifExistCategory($value->category_id, $value->name_category);
                $idCategory = json_decode($resultExistCategory);


                $productsFields = Products::updateOrCreate([
                    'erp_id' => $value->id,
                    'bar_id' => $this->bar_id,
                ], [
                    
                    'category_id' => $idCategory->id,
                    'ean_erp' => $value->ean_erp,
                    'name' => $value->name,
                    'short_name' => $value->short_name,
                    'short_description' => $value->short_description,
                    'unity' => $value->unity,
                    'quantity' => $value->quantity,
                    'price_cost_erp' => $value->price_cost_erp,
                    'price_sell_erp' => $value->price_sell,
                    'price_base'    => $value->price_base,
                    'image_url'     => $value->image_url,
                    'order' => 1,
                    'active' => 1,

                ]);
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
            ])->get('https://app.cakeerp.com/api/product_category/all?id=' . $id)['list'];
        } catch (\Throwable $th) {
            return $th;
        }

        return json_decode($response);
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
                'bar_id' => $this->bar_id])
             ->exists();
                    // DB::table('products')->where('erp_id', $idProduct)->exists();
        } catch (\Throwable $th) {
            return $th;
        };
        return $productExist;
    }

    public function statusProductCardapio($idErp,$idBar)
    {

        try {

          $result = Products::where('erp_id', $idErp) 
                ->where('bar_id',$idBar)
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

    public function ifExistCategory($idCategory, $nameCategory)
    {
        
        try {
            $categoryExist = Categories::updateOrCreate([
                'erp_id' => $idCategory,
                'bar_id' => $this->bar_id,
            ], [

                'name' => $nameCategory,   
            ]);
            $categoryExist->save();

        } catch (\Throwable $th) {
            return $th;
        }
        return $categoryExist;
    }
}
