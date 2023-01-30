<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Gate;


class ProductsController extends Controller
{
    
    public function index()
    {
        if($this->autenticacaoBar($this->bar_id) == false){
            return redirect(route('bar.selectBar'));
        }else{
            return view('cardapio.index')
            ->with('group_id',   $this->group_id );
            // ->with('bar_id', $this->bar_id);
        } 
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
   
        $fields = $products->where('active', 1)
            ->where('bar_id', $this->bar_id)
            ->orderBy('name')
            ->get();

        // Gate::authorize('visualizar_cardapio_bar',$fields);
        $data['rows'] = $fields;
        $fields_products = json_encode($data);
        return $fields_products;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        $fields = json_decode($request['data']);
        $id = $request->id;
        $name_user = $this->name_user;

        try {

            $fieldsCardapio = Products::find($id);
            $fieldsCardapio->short_name = $fields->short_name;
            $fieldsCardapio->short_description = $fields->short_description;
            $fieldsCardapio->unity = $fields->unity;
            $fieldsCardapio->price_base = $fields->price_base;
            $fieldsCardapio->order = $fields->order;
            $fieldsCardapio->updated_for = $name_user;
            $fieldsCardapio->save();
            $resultUpdate = true;
        } catch (\Throwable $th) {
            return $th;
        }

        return $resultUpdate;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Products $products)
    {
        $id = $request->id;
        $name_user = $this->name_user;
        try {
            $fieldsCardapio = Products::find($id);
            $fieldsCardapio->active = 0;
            $fieldsCardapio->updated_for = $name_user;
            $fieldsCardapio->save();
            $resultDestroy = true;
        } catch (\Throwable $th) {
            return $th;
        }

        return $resultDestroy;
    }

    public function getCategories(Request $request, Categories $categories)
    {
        
        $result = $categories
            ->where('bar_id', $this->bar_id)
            ->orderBy('name')->get();
        $data['rows'] = $result;
        $fields_categories = json_encode($data);
        return $fields_categories;
        # code...
    }

    public function getProductsCategory($id, Products $products)
    {
       
        $fields = $products
            ->where('active', 1)
            ->where('category_id', $id)
            ->where('bar_id', $this->bar_id)
            ->orderBy('order')
            ->get();

      
        return $fields;
    }
}
