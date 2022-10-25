<?php

namespace App\Http\Controllers;

use App\Models\PromosLists;

use Illuminate\Support\Facades\http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use LDAP\Result;

class PromosListController extends Controller
{

    public function index()
    {
        return view('listas.index')
        ->with('group_id', $this->group_id);
    }


    public function create(Request $request)
    {
    }


    public function store(Request $request)
    {


        $promosList = new PromosLists();
        $name = $request->name;
        $resultExistName = $promosList->existName($name);



        if ($resultExistName == true) {
            return  2;
        } else {
            $promosList->bar_id = 1;
            $promosList->name = $name;
            $promosList->inserted_for = 'Murilo';
            $promosList->save();
            return true;
        }

        return $resultExistName;
    }


    public function show()
    {
        try {
            $listAll = PromosLists::all();
            if ($listAll) {
                $data['rows'] = $listAll; //Criar formato rows para bootstrap ler o json
                $listas_data = json_encode($data); //Enviado para tabela o Json
                return $listas_data;
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }


    public function edit(PromosLists $promosList)
    {
        //
    }


    public function update(Request $request, PromosLists $promosList)
    {
        $id = $request->id;
        $name = $request->name;
        $active = $request->active;
        $bar = 1;

        try {

            $updateFieldsListPromo = PromosLists::find($id);
            $updateFieldsListPromo->bar_id = $bar;
            $updateFieldsListPromo->name = $name;
            $updateFieldsListPromo->active = $active;
            $updateFieldsListPromo->save();
            $resultUpdateListPromo = true;
        } catch (\Throwable $th) {
            return $th;
        }
        return $resultUpdateListPromo;
       
    }


    public function destroy(PromosLists $promosList)
    {
        //
    }

    public function disableListPromo(Request $request)
    {

        $fieldsActive = $request->data;
        $id = $request->id;

        try {

            PromosLists::where('active',1)
            ->update(['active' => 0]);


            $fieldsListPromo = PromosLists::find($id);
            $fieldsListPromo->bar_id = 1;
            $fieldsListPromo->active = $fieldsActive;
            $fieldsListPromo->save();
            $resultUpdateListPromo = true;
        } catch (\Throwable $th) {
            return $th;
        }
        return $resultUpdateListPromo;
    }
}
