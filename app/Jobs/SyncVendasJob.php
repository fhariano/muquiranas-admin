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

    //  public $tries = 10;
    //  public $timeout = 300;

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
   
    public function handle()
{
    $url = 'https://app.cakeerp.com/api/';
    $metododoPrincipal = 'nfe';
    $metodoFaturaVenda = 'bill_order';
    $token = '04d1be2fd17ba6769bbf';
   
    try {

    
        
        $dados = json_decode($this->json, true);

        $idOrder = $dados['idOrder'];


        $response = Http::withHeaders([
            'x-cake-token' => $token,
        ])->post($url.$metododoPrincipal, json_decode($this->json, true));

        if ($response->successful()) {
            echo 'Requisição enviada com sucesso!';
            
            // // $responseData = $response->json();
            // echo('Resposta yy : ' . $response->body());


            // echo 'Requisição enviada com sucesso!';

            $responseData = json_decode($response->json()['registry'], true);
            $idRetorno = $responseData['id'];

            Orders::where('id', $idOrder)->update(['erp_id' => $idRetorno]);
          
            // Requisição POST para a URL concatenada com o método 'bill_order' e o parâmetro 'idRetorno'
            $billOrderUrl = $url . $metodoFaturaVenda;
        //    $billOrderResponse = Http::withHeaders([
         //       'x-cake-token' => $token,
          //  ])->post($billOrderUrl, ['sales_order_id' => $idRetorno]);
          $billOrderBody = json_encode(['sales_order_id' => $idRetorno]);

          $billOrderResponse = Http::withHeaders([
              'x-cake-token' => $token,
              'content-type' => 'application/json',
              'Cookie' => 'cak3=7b53af2c08cf4edaa02b29772c61c488',
          ])->post($billOrderUrl, $billOrderBody);
    
            
        } else {
            Orders::where('id', $idOrder)->update(['post_try' => 1]);
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
