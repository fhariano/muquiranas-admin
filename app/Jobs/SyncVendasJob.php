<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use App\Models\Orders;
use App\Services\ErpService;

class SyncVendasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // public $tries = 5;
    // public $timeout = 300;

    protected $json;

    /**
     * Create a new job instance.
     *
     * @param  string  $json
     * @return void
     */
    public function __construct($json)
    {
        $this->json = $json;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    // public function handle()
    // {

       
                
    //     $url = 'https://app.cakeerp.com/api/sales_order';
    //     $token = '04d1be2fd17ba6769bbf';
    
    
    
    //     try {
    //         $response = Http::withHeaders([
    //             'x-cake-token' => $token,
    //         ])->post($url, json_decode($this->json, true));
    
    //         // Verifique a resposta e tome as ações necessárias
    
    //         if ($response->successful()) {
    //             // A solicitação foi bem-sucedida (código de status 2xx)
    //             // Faça algo com a resposta

    //             echo('  Requisição enviada com sucesso order xx :)!');
                
    //             // echo('Resposta yy : ' . $response->body());
                
    //              $responseData = json_decode($response->body(), true);
    //              $id = $responseData['registry']['id'];
                               
    //             // echo('ID É  : ' . $id);
                
                
    //             // Atualizar o campo "erp_ir" na tabela "order" onde o ID é igual
    //             Orders::where('id', 6)->update(['erp_id' => 66]);
    //             // PromosLists::where('status',1) ->update(['status' => 0]);
    //             // Log::info('Job SyncVendasJob concluído.');

    //         } else {
    //             // A solicitação falhou (código de status diferente de 2xx)
    //             // Obtenha o código de status e a mensagem de erro
    //             $statusCode = $response->status();
    //             $errorMessage = $response->body();
    
    //             dd ('Erro na requisição: ' . $errorMessage);
    //             //criar função para informar atualizar a order com 1 quando a tentativa der errado.
    //             // Faça algo com o código de status e a mensagem de erro
    //         }
    //     } catch (RequestException $e) {
    //         // Ocorreu uma exceção durante a solicitação HTTP
    //         // Obtenha a mensagem de erro da exceção
    //         $errorMessage = $e->getMessage();
    
    //         // Faça algo com a mensagem de erro
    //         echo('deu erro');
    //     }
             
    // }





    public function handle()
{
    $url = 'https://app.cakeerp.com/api/sales_order';
    $token = '04d1be2fd17ba6769bbf';

    try {

        $dados = json_decode($this->json, true);
        $idOrder = $dados['idOrder'];


        $response = Http::withHeaders([
            'x-cake-token' => $token,
        ])->post($url, json_decode($this->json, true));

        if ($response->successful()) {
            // echo 'Requisição enviada com sucesso!';
            
            // // $responseData = $response->json();
            // echo('Resposta yy : ' . $response->body());


            // echo 'Requisição enviada com sucesso!';

            $responseData = json_decode($response->json()['registry'], true);
            $idRetorno = $responseData['id'];

            echo 'ID: ' . $idRetorno;
            // echo 'Date Sell: ' . $responseData['date_sell'];
            // echo 'Date Order: ' . $responseData['date_order'];
            // echo 'Customer: ' . $responseData['customer'];
            // echo 'Delivery Time: ' . $responseData['delivery_time'];

            Orders::where('id', $idOrder)->update(['erp_id' => $idRetorno]);
          
            
            // Outras ações necessárias após uma resposta bem-sucedida
            
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();

            echo 'Erro na requisição: ' . $errorMessage;

            // Outras ações necessárias após uma resposta com erro
        }
    } catch (RequestException $e) {
        $errorMessage = $e->getMessage();

        echo 'Ocorreu um erro na solicitação HTTP: ' . $errorMessage;

        // Outras ações necessárias após uma exceção
    }
}

}
