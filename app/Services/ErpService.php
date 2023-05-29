<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ErpService
{
    public static function syncOrder($order)
    {
        // Faça a chamada HTTP para obter os pedidos do ERP
        $response = Http::post('https://app.cakeerp.com/api/sales_order');

        // Verifique se a chamada foi bem-sucedida
        if ($response->successful()) {
            // Retorne os pedidos como uma matriz JSON
            return $response->json();
        } else {
            // Se a chamada falhar, retorne null ou um valor padrão, ou trate o erro de acordo com a sua necessidade
            return null;
        }
    }
}
