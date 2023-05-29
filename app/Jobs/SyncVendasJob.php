<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use App\Services\ErpService;

class SyncVendasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        // // Realizar a chamada HTTP POST e salvar o retorno na tabela desejada
        // $response = Http::post('https://app.cakeerp.com/api/sales_order', json_decode($this->json, true));

        // // Salvar o retorno na tabela usando o Eloquent ORM ou o DB facade
        // // Exemplo usando Eloquent ORM:
        //  $orders = ErpService::getOrdersForErp(order);

        // if ($orders !== null) {
        //     // Faça o processamento dos pedidos aqui
        //     // ...
        //     $orders->response = $response->body();
        //     $orders->save();

        // } else {
        //     // Trate o erro de acordo com a sua necessidade
        //     // ...
        // }





        
        $url = 'https://app.cakeerp.com/api/sales_order';
        $token = '04d1be2fd17ba6769bbf';
    
    
    
        try {
            $response = Http::withHeaders([
                'x-cake-token' => $token,
            ])->post($url, json_decode($this->json, true));
    
            // Verifique a resposta e tome as ações necessárias
    
            if ($response->successful()) {
                // A solicitação foi bem-sucedida (código de status 2xx)
                // Faça algo com a resposta

                echo('Requisição enviada com sucesso:)!');
                dd('Resposta: ' . $response->body());
            } else {
                // A solicitação falhou (código de status diferente de 2xx)
                // Obtenha o código de status e a mensagem de erro
                $statusCode = $response->status();
                $errorMessage = $response->body();
    
                dd ('Erro na requisição: ' . $errorMessage);
                // Faça algo com o código de status e a mensagem de erro
            }
        } catch (RequestException $e) {
            // Ocorreu uma exceção durante a solicitação HTTP
            // Obtenha a mensagem de erro da exceção
            $errorMessage = $e->getMessage();
    
            // Faça algo com a mensagem de erro
        }
    
  
       
    }
}
