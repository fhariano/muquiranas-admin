<?php

namespace App\Http\Controllers;
use App\Models\ProductsPromosLists;
use App\Models\PromosLists;
use App\Models\Products;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use LDAP\Result;

use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\returnSelf;

class ProductsPromosListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $price;

    public function index()
    {
        if($this->autenticacaoBar($this->bar_id) == false){
            return redirect(route('bar.selectBar'));
        }else{
            $resultPromoList = PromosLists::where(['bar_id' => $this->bar_id,])->get();
            $resultProduct = Products::where(['bar_id' => $this->bar_id,])->get();
            return view('promocoes.index', 
            [
                'resultPromoList' => $resultPromoList, 
                'resultProducts' => $resultProduct, 
                'group_id' => $this->group_id
            ]);
        } 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo ("Entrou no create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        $fields = json_decode($request['data']);
        $nameTable = 'products_promos_lists';
        $idList = $fields->idList;
        $idProduct = $fields->product_id;
        $hourStart = $fields->hourStart;
        $hourEnd =  $fields->hourEnd;
        $price = $fields->price;

        // return "ID Lista: ".$idList." ID PRoduto: ".$idProduct."Hora Inicio: ".$hourStart."Hora Fim: ".$hourEnd."Preço: ".$price;

        try {
            $resultCheckExistProduct = $this->checkIfProductFieldsExits($idList, $idProduct, $hourStart, $hourEnd);
        } catch (\Throwable $th) {
            return $th;
        }
        
          switch ($resultCheckExistProduct) {
            case true:
                return 2; //Já existe um registro com mesmo horário
                break;

            case false:
                //INSERTED_FOR = DEFAULT "Murilo"
                //UPDATED_FOR = DEFAULT "Murilo"
                //ATIVE    = DEFAULT 1
                $productPromosFields = new ProductsPromosLists();
                $productPromosFields->promos_list_id = $idList;
                $productPromosFields->product_id = $idProduct;
                $productPromosFields->hour_start = $hourStart;
                $productPromosFields->hour_end = $hourEnd;
                $productPromosFields->price = $price;
                $productPromosFields->inserted_for = $this->name_user;
                $productPromosFields->save();
                return  true;
                break;
            case 0:
                return 0;
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductsPromosList  $productsPromosList
     * @return \Illuminate\Http\Response
     */
    public function show($idLista)
    {
        try {
            $productsPromosAll =  DB::table('products_promos_lists AS ppl')
                ->select('ppl.promos_list_id', 'ppl.product_id', 'p.id', 'p.short_name', DB::raw('count(1) as qtd'))

                ->leftJoin('products AS p', function ($join) {
                    $join->on('ppl.product_id', '=', 'p.id')->where('p.active', 1);
                })
                ->where('ppl.promos_list_id', $idLista)
                ->groupBy(['ppl.promos_list_id', 'ppl.product_id'])
                ->get();

            if ($productsPromosAll) {
                $data['rows'] = $productsPromosAll; //Criar formato rows para bootstrap ler o json
                $productsPromosAllJson = json_encode($data); //Enviado para tabela o Json
            }
        } catch (\Throwable $th) {
            return $th;
        }

        return $productsPromosAllJson;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductsPromosList  $productsPromosList
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductsPromosLists $productsPromosList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, ProductsPromosLists $productPromosFields)
    {
        // $res=json_encode($request['data']);
        $fields = json_decode($request['data']);
        $requestId = json_decode($request['id']);

        $idList = $fields->idList;
        $idProduct = $fields->product_id;
        $hourStart = $fields->hourStart;
        $hourEnd =  $fields->hourEnd;
        $price = $fields->price;
        $id = $request->id;

        try {
            $resultCheckExistProduct = $this->checkIfProductFieldsExitsUpdate($idList, $idProduct, $hourStart, $hourEnd, $id);
        } catch (\Throwable $th) {
            return $th;
        }

        switch ($resultCheckExistProduct) {
            case true:
                return 2; //Já existe um registro com mesmo horário
                break;

            case false:

                $productPromosFields = ProductsPromosLists::find($id);
                $productPromosFields->promos_list_id = $idList;
                $productPromosFields->product_id = $idProduct;
                $productPromosFields->hour_start = $hourStart;
                $productPromosFields->hour_end = $hourEnd;
                $productPromosFields->price = $price;
                $productPromosFields->updated_for = $this->name_user;

         
                $productPromosFields->save();
                return  true;
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductsPromosList  $productsPromosList
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ProductsPromosLists $productsPromosList)
    {
        $id = $request->id;
        try {
            $idProductExist = DB::table('products_promos_lists')->where('id', $id)->exists();
        } catch (\Throwable $th) {
            return $th;
        };
        if($idProductExist == true){
            ProductsPromosLists::find($id)->delete();
            return true;
        }else{
            return 2;
        }
       
    }

    

    public function getProductsList($idList, $idProduct)
    {
        try {
            $products = DB::table('products_promos_lists AS ppl')
                ->select('ppl.*')
                ->where('promos_list_id', $idList)
                ->where('product_id', $idProduct)
                ->orderBy('hour_end')
                ->get();
        } catch (\Throwable $th) {
            return $th;
        }
        return $products;
    }

    public function checkIfProductFieldsExits($fieldIdList, $fieldIdProduct, $fieldHourStart, $fieldHourEnd)
    {
        $fieldHourStart = $fieldHourStart . ':00';
        $fieldHourEnd = $fieldHourEnd . ':00';

        try {
            $result =  DB::table('products_promos_lists AS ppl')
                ->select('ppl.*')
                ->where('promos_list_id', $fieldIdList)
                ->where('product_id', $fieldIdProduct)
                ->whereRaw("((TIME(hour_start) BETWEEN '$fieldHourStart' AND '$fieldHourEnd') OR ( TIME(hour_end) BETWEEN '$fieldHourStart' AND '$fieldHourEnd'))")
                ->get();
            Log::channel('muquiranas')->info("SQL: " . print_r($result, true));
        } catch (\Throwable $th) {
            return 0;
        }

        $resultQuery = count($result); //Quantos objetos foi retornado       

        if ($resultQuery == 0) {
            return false;
        } else {
            return true;
        }
    }


    public function checkIfProductFieldsExitsUpdate($fieldIdList, $fieldIdProduct, $fieldHourStart, $fieldHourEnd, $id)
    {
        $fieldHourStart = $fieldHourStart . ':00';
        $fieldHourEnd = $fieldHourEnd . ':00';

        try {
            $result =  DB::table('products_promos_lists AS ppl')
                ->select('ppl.*')
                ->where('promos_list_id', $fieldIdList)
                ->where('product_id', $fieldIdProduct)
                ->whereRaw("((TIME(hour_start) BETWEEN '$fieldHourStart' AND '$fieldHourEnd') OR ( TIME(hour_end) BETWEEN '$fieldHourStart' AND '$fieldHourEnd'))")
                ->where('id', '<>', $id)
                ->get();
            Log::channel('muquiranas')->info("SQL: " . print_r($result, true));
        } catch (\Throwable $th) {
            return $th;
        }

        $resultQuery = count($result); //Quantos objetos foi retornado       

        if ($resultQuery == 0) {
            return false;
        } else {
            return true;
        }
    }

    // public function checkRequestProduct($idList, $idProduct, $hourStart, $hourEnd, $price)
    // {
    //     if (!$idList || $idList == '') {
    //         return false;
    //     }
    //     if (!$idProduct || $idProduct == '') {
    //         return false;
    //     }
    //     if (!$hourStart || $hourStart == '') {
    //         return false;
    //     }
    //     if (!$hourEnd || $hourEnd == '' || $hourEnd < $hourStart) {
    //         return false;
    //     }
    //     if (!$price || $price == '' || $price == 0) {
    //         return false;
    //     }
    //     return true;
    // }
}
