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
        if($this->autenticacaoBar($this->bar_id) == false){
            return redirect(route('bar.selectBar'));
        }else{
            return view('listas.index')
            ->with('group_id', $this->group_id);
        }

    }


    public function create(Request $request)
    {
    }


    public function store(Request $request)
    {


        $promosList = new PromosLists();
        $name = $request->name;
        $resultExistName = $promosList->existName($name, $this->bar_id);



        if ($resultExistName == true) {
            return  2;
        } else {
            $promosList->bar_id = $this->bar_id ;
            $promosList->name = $name;
            $promosList->inserted_for =  $this->name_user;
            $promosList->updated_for = $this->name_user;
            $promosList->save();
            return true;
        }

        return $resultExistName;
    }


    public function show()
    {
        try {
            $listAll = PromosLists::where(['bar_id' => $this->bar_id , 'active' => 1])->get();
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
        $status = $request->status;
        $bar = $this->bar_id;

        try {

            $updateFieldsListPromo = PromosLists::find($id);
            $updateFieldsListPromo->bar_id = $bar;
            $updateFieldsListPromo->name = $name;
            $updateFieldsListPromo->status = $status;
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

            PromosLists::where('status',1)
            ->update(['status' => 0]);

            $fieldsListPromo = PromosLists::find($id);
            $fieldsListPromo->bar_id = $this->bar_id;
            $fieldsListPromo->status = $fieldsActive;
            $fieldsListPromo->save();
            $resultUpdateListPromo = true;
        } catch (\Throwable $th) {
            return $th;
        }
        return $resultUpdateListPromo;
    }
    public function destroyListPromo(Request $request)
    {
       
         $idList= $request->id;
         
        try {
            $destroyListPromo = PromosLists::find($idList);
            $destroyListPromo->active= false;
            $destroyListPromo->save();
            $resultDestroyListPromo = true;
        } catch (\Throwable $th) {
            return $th;
        }
        return $resultDestroyListPromo;
      
    }
}
