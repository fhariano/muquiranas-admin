<?php

namespace App\Http\Controllers;

use App\Models\Bars;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class BarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Gate::allows('visualizar_bar', $this->group_id)) {
            return view('bar.index')
                ->with('group_id', $this->group_id);
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

            // $barFields = new Bars();
            // $barFields->name = $fields->name;
            // $barFields->short_name = $fields->short_name;
            // $barFields->address = $fields->address;
            // $barFields->city_state = $fields->city_state;
            // $barFields->start_at = $fields->start_at;
            // $barFields->end_at = $fields->end_at;
            // $barFields->order = $fields->order;
            // $barFields->inserted_for = $this->name_user;
            // $barFields->save();

            $barFields = new Bars();
            $barFields->name = $fields->name;
            $barFields->short_name = $fields->short_name;
            $barFields->address = $fields->address;
            $barFields->city_state = 'Salvador';
            $barFields->start_at = '14:00';
            $barFields->end_at = '01:00';
            $barFields->order = '3';
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
            $updateBarFields->name = $fields->name;
            $updateBarFields->short_name = $fields->short_name;
            $updateBarFields->address = $fields->address;
            // $updateBarFields->city_state = 'Salvador';
            // $updateBarFields->start_at = '14:00';
            // $updateBarFields->end_at = '01:00';
            // $updateBarFields->order = '3';
            // $updateBarFields->inserted_for = $this->name_user;
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
}
