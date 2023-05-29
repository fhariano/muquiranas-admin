<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class SyncOrderForErp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postOrderErp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar dados as order do admin para o erp';

    /**
     * Execute the console command.
     *
     * @return int
     */
    // public function handle()
    // {
    //     return Command::SUCCESS;
    // }

    // $json = '{
    //     "order_type": 1,
    //     "fiscal_operation": 24052,
    //     "date_order": "2023-05-28",
    //     "date_sell": "2023-05-28",
    //     "customer": 9285552,
    //     "payment_form": 59702,
    //     "seller": 45574,
    //     "delivery_time": "2023-05-28"
    // }';

    public function handle($json)
    {
    
        $url = 'https://app.cakeerp.com/api/sales_order';
        $token = '04d1be2fd17ba6769bbf';
    
        // $json = '{
        //     "order_type": 1,
        //     "fiscal_operation": 24052,
        //     "date_order": "2023-05-28",
        //     "date_sell": "2023-05-28",
        //     "customer": 9285552,
        //     "payment_form": 59702,
        //     "seller": 45574,
        //     "delivery_time": "2023-05-28"
        // }';
    
        try {
            $response = Http::withHeaders([
                'x-cake-token' => $token,
            ])->post($url, json_decode($json, true));
    
            // Verifique a resposta e tome as ações necessárias
    
            if ($response->successful()) {
                // A solicitação foi bem-sucedida (código de status 2xx)
                // Faça algo com a resposta

                $this->info('Requisição enviada com sucesso!');
                $this->info('Resposta: ' . $response->body());
            } else {
                // A solicitação falhou (código de status diferente de 2xx)
                // Obtenha o código de status e a mensagem de erro
                $statusCode = $response->status();
                $errorMessage = $response->body();
    
                $this->error('Erro na requisição: ' . $errorMessage);
                // Faça algo com o código de status e a mensagem de erro
            }
        } catch (RequestException $e) {
            // Ocorreu uma exceção durante a solicitação HTTP
            // Obtenha a mensagem de erro da exceção
            $errorMessage = $e->getMessage();
    
            // Faça algo com a mensagem de erro
        }
    
        return Command::SUCCESS;

    }





}
