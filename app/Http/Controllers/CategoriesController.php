<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class CategoriesController extends Controller
{
 

    public function index()
    {
        return view('categorias.index')
        ->with ('group_id', $this->group_id);
    }

 
    public function create()
    {
        
    }


    public function store(Request $request)
    {
        //
    }

 
    public function show(Categories $categories)
    {
        $idBar = Auth::user()->bar_id;
        $fieldsCategories = $categories->where('bar_id',$idBar)
        ->orderBy('order')
        ->get();

        // $categories = Categories::all(); 
        $data['rows'] = $fieldsCategories;
        $categories_data=json_encode($data);
        return ($categories_data);
      }


  
    public function disableCategory (Request $request)
    {
        $fieldsActive = $request->data;
        $id = $request->id;
        $idBar = Auth::user()->bar_id;

        try{

           $fieldsCategories = Categories::find($id);
           $fieldsCategories->bar_id = $idBar;
           $fieldsCategories->active = $fieldsActive;
           $fieldsCategories->save();
           $resultUpdate = true;

        }catch(\Throwable $th){
            return $th;
        }
        return $resultUpdate;
    }
  
    public function edit(Categories $categories)
    {
        


    }

 
    public function update(Request $request, Categories $categories)
    {
        
        $idBar = Auth::user()->bar_id;
        $id = $request->id;
        $name = $request->name;
        $order = $request->order;
      
        try{

           $fieldsCategories = Categories::find($id);
           $fieldsCategories->bar_id = $idBar;
           $fieldsCategories->name = $name;
           $fieldsCategories->order = $order;
           $fieldsCategories->save();
           $resultUpdate = true;

        }catch(\Throwable $th){
            return $th;
        }
        
        // return view('categories.index');

        return $resultUpdate;
    }

  
    public function destroy(Categories $categories)
    {
        //
    }
}
