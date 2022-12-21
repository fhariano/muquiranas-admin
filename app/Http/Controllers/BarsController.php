<?php

namespace App\Http\Controllers;

use App\Models\Bars;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\BarsHistory;

class BarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $group = Auth::user()->group_id; 
        $idBar = Auth::user()->bar_id;
        $statusBar = $this->getStatusBar($idBar);

        if (Gate::allows('visualizar_bar', $this->group_id)) {
            return view('bar.index')
                ->with('group_id', $this->group_id)
                ->with('statusBar', $statusBar)
                ->with('group', $group);
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
        $fields = json_decode($request['data']);


        try {

            $barFields = new Bars();
            $barFields->erp_token = $fields->erp_token;
            $barFields->cnpj = $fields->cnpj;
            $barFields->name = $fields->name;
            $barFields->short_name = $fields->short_name;
            $barFields->address = $fields->address;
            $barFields->complement = $fields->complement;
            $barFields->number = $fields->number;
            $barFields->cep = $fields->cep;
            $barFields->city_state =  $fields->city_state;
            $barFields->start_at = $fields->start_at;
            $barFields->end_at =  $fields->end_at;
            $barFields->order = $fields->order;
            $barFields->inserted_for = $this->name_user;
            $barFields->save();
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if ($this->group_id === 1) {

            try {
                $barAll = Bars::where(['active' => 1])->get();

                if ($barAll) {
                    $data['rows'] = $barAll;
                    $bar_data = json_encode($data);
                    return $bar_data;
                }
            } catch (\Throwable $th) {
                return $th;
            }
        } else {

            try {
                $barAll = Bars::where(['id' => $this->bar_id])->get();

                if ($barAll) {
                    $data['rows'] = $barAll;
                    $bar_data = json_encode($data);
                    return $bar_data;
                }
            } catch (\Throwable $th) {
                return $th;
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, Bars $bars)
    {
        $fields = json_decode($request['data']);
        $id = $request->id;

        try {
            $updateBarFields = Bars::find($id);        
            $updateBarFields->erp_token = $fields->erp_token;
            $updateBarFields->cnpj = $fields->cnpj;
            $updateBarFields->name = $fields->name;
            $updateBarFields->short_name = $fields->short_name;
            $updateBarFields->address = $fields->address;
            $updateBarFields->complement = $fields->complement;
            $updateBarFields->number = $fields->number;
            $updateBarFields->cep = $fields->cep;
            $updateBarFields->city_state =  $fields->city_state;
            $updateBarFields->start_at = $fields->start_at;
            $updateBarFields->end_at =  $fields->end_at;
            $updateBarFields->order = $fields->order;
            $updateBarFields->updated_for = $this->name_user;
            $updateBarFields->save();
            $resultUpdateBar = true;
        } catch (\Throwable $th) {
            return $th;
        }
        return $resultUpdateBar;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $destroyBarFilds = Bars::find($request->id);
            $destroyBarFilds->active = 0;
            $destroyBarFilds->save();
            $resultDestroyBar = true;

        }catch(\Throwable $th) {
            return $th;
        }

        return $resultDestroyBar;   
    }
    public function updateStatusBar(Request $request, Bars $Bars) 
    {
        $idBar = Auth::user()->bar_id;

        try {
            $this->actionBar($request->status);
            $barFields = Bars::find($idBar);
            $barFields->status = $request->status;
            $barFields->save();
        
          
        }catch (\Throwable $th){
            return $th;
        }
          return true; 
    }

    public function actionBar($action){

        if($action === '1'){
            $action = 'Abriu Bar';
        }else{
            $action = 'Fechou Bar';
        }

        try {

            $barsHistoryFilds = new BarsHistory();
            $barsHistoryFilds->bar_id = Auth::user()->bar_id;
            $barsHistoryFilds->user_id = Auth::user()->id;
            $barsHistoryFilds->name = Auth::user()->name;
            $barsHistoryFilds->inserted_for = Auth::user()->name;
            $barsHistoryFilds->action = $action;
            $barsHistoryFilds->save();

        }catch(\Throwable $th){
            return $th;
        }

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
}
