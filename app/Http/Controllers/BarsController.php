<?php

namespace App\Http\Controllers;

use App\Models\Bars;
use App\Models\Dashboard;
use App\Models\UsersBar;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Orders;
use App\Models\BarsHistory;
use JeroenNoten\LaravelAdminLte\View\Components\Form\Select;
use Laravel\Sail\Console\PublishCommand;


class BarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $receitasBares;
    
    public function index(Request $request)
    {
        
        if($this->autenticacaoBar($this->bar_id) == false){
            return redirect(route('bar.selectBar'));
        }else{
        
            if (Gate::allows('visualizar_bar', $this->group_id)) {
                return view('bar.index')
                    ->with('group_id', $this->group_id)
                    ->with('bar_id', $this->bar_id)

                    // ->with('statusBar', $this->getStatusBar($this->bar_id))
                    ->with('statusBar', $this->statusBar)
                    ->with('group', $this->group_id);
            } 
        }

       
    }

    /**
     * Função chamado via Ajax na view selectBar, onde vai buscar informações do usuário e do bar no qual ele selecionou. 
     * e atualizar a session. 
     */
    public function requestSelectBar(Request $request) 
    {
        $fildsBarSelected = $this->UserIsOwnerOfBarSelected(Auth::user()->id, $request['idBarSelecionado'] );
               
        //  return $this->atualizaSessionFieldBarSelecionado($fildsBarSelected);
          return route('home');
    }


    public function selectBar(Request $request)
    {

        /***
            Pega o id o usuário e verifica o group. 
            Atualiza os dados da session se for diferente de 6 e 7  e redireciona para home. 
            se não, tras informações dos bares que estão associados ao usuário, redireciona o mesmo para o 
            selecionar um bar . 
        */            
        $fieldUserAtual = $this->fieldUser(Auth::user()->id);
        
      
        if($fieldUserAtual[0]->group_id !=6 && $fieldUserAtual[0]->group_id !=7){
            $this->atualizaSession($fieldUserAtual);
            $this->atualizaReceitasSession($this->getReceitaBar($fieldUserAtual[0]->bar_id));
           
            $this->salvaDadosBaresUsuarioSession($fieldUserAtual);
            return redirect(route('home'));
        }else{

           $fieldsBarsUser = $this->UserIsOwnerOfBar(Auth::user()->id);
        //    $this->receitasBares = $this->getReceitaBar($fieldsBarsUser);
          $this->atualizaReceitasSession($this->getReceitaBar($fieldsBarsUser));
          $this->salvaDadosBaresUsuarioSession($fieldsBarsUser);
           return view('bar.selectBar')
           ->with('fieldsBarsUser', $fieldsBarsUser);
           $this->atualizaSession($fieldUserAtual);
        }

   
    }

    public function requestValorReceita(Request $request){

        $resultReceitaBar = 0;
       
        try {
            $resultReceitaBar = $this->consolidadoReceitas($request->idBar);
        } catch (\Throwable $th) {
            return $th;
        }

        return $resultReceitaBar;
    }

    public function getReceitaBar($idbars) {    
        $resultReceitaBar = 0;
        if( is_array($idbars)){ //Verifica se é array com ids dos bares, onde é passado o id de cada bar no foreache e alimentando a variavel resultReceitaBar .
            foreach ($idbars as $bar) {
                $resultReceitaBar += $this->consolidadoReceitas($bar->bar_id);
                }
        }else{
            $resultReceitaBar += $this->consolidadoReceitas($idbars);
        }
        
        return $resultReceitaBar;
    }

    public function consolidadoReceitas($idBar){
        $totalBar = Orders::select(
            DB::raw('sum(total) as totalBar'),
        )
            ->where('bar_id', $idBar)
            ->where('active', 1)
            ->whereNull('erp_id')
            ->get();  
        return $totalBar[0]->totalBar;
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
        //MELHORAR A FUNÇÃO
        if ($this->group_id === 1) {

            try {
                $barAll = Bars::where(['active' => 1])->where(['id' => $this->bar_id])->get();

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
        // $idBar = Auth::user()->bar_id;
        
       
        try {
            $this->actionBar($request->status);
            $barFields = Bars::find($this->bar_id);
            $barFields->status = $request->status;
            $barFields->updated_for = Auth::user()->name;
          
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
            $barsHistoryFilds->bar_id = $this->bar_id;
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

    public function fieldUser($idUser)
    {
        try{

            $resultFieldUser = UsersBar::select(
                DB::raw('users_bars.bar_id as bar_id'),
                DB::raw('users_bars.group_id as group_id'),
                DB::raw('bars.status as statusBar'),
                DB::raw('bars.short_name as nameBar'),
                DB::raw('users_bars.is_owner as is_owner'),
               
            )
                ->join('bars as bars', 'bars.id', '=', 'bar_id')
                ->where([
                    'user_id' => $idUser,
                ])
                ->get();

        }catch(\Throwable $th){
            return $th;
        }
        return json_decode($resultFieldUser);
    }

    public function UserIsOwnerOfBar($idUser)
    {
        $resultIsOwnerOfBar = UsersBar::select(
            DB::raw('users_bars.bar_id as bar_id'),
            DB::raw('users_bars.group_id as group_id'),
            DB::raw('bars.status as statusBar'),
            DB::raw('bars.short_name as nameBar'),
            DB::raw('users_bars.is_owner as DonoBar'),

        )
            ->join('bars as bars', 'bars.id', '=', 'bar_id')
            ->where([
                'user_id' => $idUser,
                // 'is_owner' => '1',
                // 'group_id' => '6'
            ])
            ->get();

        return json_decode($resultIsOwnerOfBar);
    }


    public function UserIsOwnerOfBarSelected($idUser, $idBar)
{
    $resultIsOwnerOfBarSelected = UsersBar::select(
        DB::raw('users_bars.bar_id as bar_id'),
        DB::raw('users_bars.group_id as group_id'),
        DB::raw('bars.status as statusBar'),
        DB::raw('bars.short_name as nameBar'),
        DB::raw('users_bars.is_owner as DonoBar'),
    )
        ->join('bars as bars', 'bars.id', '=', 'bar_id')
        ->where([
            'user_id' => $idUser,
            // 'is_owner' => '1', //Verificar com Ariano, esse campo. 
            'bar_id' => $idBar,
        ])
        ->get();

    if (!empty($resultIsOwnerOfBarSelected)) {
        $barId = $resultIsOwnerOfBarSelected[0]->bar_id;
        $groupId = $resultIsOwnerOfBarSelected[0]->group_id;
        $statusBar = $resultIsOwnerOfBarSelected[0]->statusBar;
        $nameBar = $resultIsOwnerOfBarSelected[0]->nameBar;
        $donoBar = $resultIsOwnerOfBarSelected[0]->DonoBar;

        // return $resultIsOwnerOfBarSelected;

        session([
                    'bar_id' => $barId,
                    'nameBar' => $nameBar,
                    'group_id' => $groupId,
                    'statusBar' => $statusBar,
                ]);

                return true;
    }

    return null;
}


//Atualizar dados da sessão ;
    public function atualizaSession($fields)
    {
      
             return session([
            'bar_id' => $fields[0]->bar_id,
            'nameBar' => $fields[0]->nameBar,
            'group_id' => $fields[0]->group_id,
            'statusBar' => $fields[0]->statusBar,
         
        ]);
    }




    public function atualizaReceitasSession($valor)
    {
        return session(['receitasBar' =>  $valor]);
    }

    public function salvaDadosBaresUsuarioSession($fieldsBares){
    //  $bar = [
    //     'bar_id' => 'Teste Murilo',

    //  ] ;
        return session(['baresUserLogado' => $fieldsBares]);

    }




    

}


