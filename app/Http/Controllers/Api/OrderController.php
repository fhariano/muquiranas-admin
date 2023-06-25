<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder;
use App\Models\Orders;
use App\Models\PromosLists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Jobs\SyncVendasJob;

class OrderController extends Controller
{
    protected $model;
    protected $apikey;
    protected $authorization;

    /**
     * Bar_Code (000-000000-0000-000000-000): order_id-product_id-item
     *    product_id: 6 caracteres podendo chegar a 999999 (~ 1 milhão)
     *    item: 3 caracteres podendo chegar a 999 (~ mil por proudct_id) (se comprar 3 itens do mesmo produto vai de 1-3)
     *
     * Order_Id (000-000000-0000): bar_id-user_id-count
     *    bar_id: 3 caracteres podendo chegar a 999 (~ mil bares)
     *    user_id: 6 caracteres podendo chegar 999999 (~ 1 milhão de usuários)
     *    count: 4 caracteres podendo chegar 9999 (~ 10 mil ordens por usuário )
     */

    public function __construct(Orders $order)
    {
        $this->model = $order;
        $this->authorization = request()->header('Authorization');
        $this->apikey = request()->header('apikey');
        request()->request->add(['apikey' => $this->apikey]);
    }

    /**
     * Display a listing of the resource.
     *
     
     
     */
    public function index($user_id, $bar_id)
    {
        $orders = DB::table('orders')
            ->select('orders.*')
            ->leftJoin('bars', 'orders.bar_id', 'bars.id')
            ->where('orders.client_id', $user_id)
            ->where('orders.bar_id', $bar_id)
            ->where('orders.active', 1)
            ->where('bars.active', 1)
            ->orderBy('orders.id', 'desc')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }

     foreach ($orders as $order) {
            $items = DB::table('orders_items AS oi')
                ->select(
                    'oi.order_id',
                    'oi.item',
                    'oi.product_id',
                    'p.erp_id',
                    'p.short_name',
                    'p.short_description',
                    'p.marca',
                    'p.unity',
                    'p.image_url',
                    'oi.quantity',
                    'oi.price',
                    'oi.total',
                    'oi.promo',
                    'oi.promo_expire',
                    'ob.used'
                )
                ->leftJoin('products AS p', 'oi.product_id', 'p.id')
                ->leftJoin(
                    DB::raw('(SELECT order_id, count(1) as used FROM orders_barcodes WHERE active = 0 GROUP BY order_id, product_id) AS ob'),
                    'oi.order_id',
                    'ob.order_id'
                )
                ->where('oi.order_id', $order->id)
                ->orderBy('oi.item', 'asc')
                ->get();

            foreach ($items as $item) {
                $barcodes = DB::table('orders_barcodes AS ob')
                    ->where('ob.order_id', $item->order_id)
                    ->where('ob.product_id', $item->product_id)
                    ->orderby('ob.barcode')
                    ->get();

                $item->barcodes = $barcodes;
                $item->used = $item->used ? $item->used : 0;
                $order->items[] = $item;
            }
        }

        return response()->json([
            "error" => false,
            "message" => "Lista de orders!",
            "data" => $orders
        ], 200);

        
    }

    public function show($order_num)
    {
        $order = DB::table('orders')
            ->select('orders.*')
            ->leftJoin('bars', 'orders.bar_id', 'bars.id')
            ->where('orders.order_num', $order_num)
            ->where('orders.active', 1)
            ->where('bars.active', 1)
            ->orderBy('orders.id', 'desc')
            ->get();

        if ($order->isEmpty()) {
            return response()->json([
                "error" => true,
                "message" => "Nenhum registro foi encontrado!",
                "data" => [],
            ], 404);
        }

        foreach ($order as $order) {
            $items = DB::table('orders_items AS oi')
                ->select(
                    'oi.order_id',
                    'oi.item',
                    'oi.product_id',
                    'p.erp_id',
                    'p.short_name',
                    'p.short_description',
                    'p.marca',
                    'p.unity',
                    'p.image_url',
                    'oi.quantity',
                    'oi.price',
                    'oi.total'
                )
                ->leftJoin('products AS p', 'oi.product_id', 'p.id')
                ->where('order_id', $order->id)
                ->orderBy('oi.item', 'asc')
                ->get();

            foreach ($items as $item) {
                $order->items[] = $item;
            }
        }

        return response()->json([
            "error" => false,
            "message" => "Order by id!",
            "data" => $order,
        ], 200);
    }

    public function store(StoreOrder $request)
    {
        $data = $request->validated();

        // Log::channel('muquiranas')->info('ORDER - user identify:' . $this->identify);
        // Log::channel('muquiranas')->info('ORDER - data: ' . print_r($data, true));

        // Primeiro: Checar itens do carrinho!
        // - quantidade do item em estoque
        // Segundo: Checar itens em promoção
        // - promoção ainda é válida?
        $items = [];
        $items = $data['items'];

        $softDescriptor = '';

        for ($i = 0; $i < count($items); $i++) {
            Log::channel('orderlog')->info('ORDER item:' . print_r($items[$i], true));

            $result = DB::table('bars as b')
                ->leftJoin('products as p', 'b.id', '=', 'p.bar_id')
                ->where('b.id', $data['bar_id'])
                ->where('p.id', $items[$i]['product_id'])
                ->select('b.soft_descriptor', 'p.*')
                ->first();

            if (!$result) {
                // Retorna erro se o produto não está mais no cardápio ou sem estoque!
                Log::channel('orderlog')->warning('ORDER: ' . $data['order_num'] . ' - stock: ' . $items[$i]['short_name'] . ' - FORA DO CARDÁPIO');
                return response()->json([
                    "error" => true,
                    "message" => "O produto {$items[$i]['short_name']} não está mais no cardápio!\nRemova este produto da sacola!",
                    "data" => []
                ], 422);
            }

            Log::channel('orderlog')->info('ORDER estoque result  :' . print_r($result, true));
            Log::channel('orderlog')->info('ORDER: ' . $data['order_num'] . ' - stock: ' . $result->short_name . ' - item qtd: '
                . $items[$i]['quantity'] . ' - stock qtd: ' . $result->quantity . ' - min qtd: ' . config('microservices.minStock')
                . ' - app price: ' . $items[$i]['price']);

            // Retorna erro se o produto está abaixo do estoque mínimo (microservices.minStock - ver .env)
            if ($result->quantity < config('microservices.minStock')) {
                Log::channel('orderlog')->warning('ORDER: ' . $data['order_num'] . ' - stock: ' . $result->short_name . ' - SEM ESTOQUE');
                return response()->json([
                    "error" => true,
                    "message" => "O produto {$result->short_name} está Sem Estoque!\nRemova este produto da sacola!",
                    "data" => []
                ], 422);
            }

            // Verifica se o produto está em promoção e se a promoção é válida para o horário corrente
            if ($items[$i]['promo'] == 1) {
                $nowTime = \Carbon\Carbon::now()->addMinutes(config('microservices.stopPromo'));
                $nowTime = (string) $nowTime->format('H:i:s');

                $promo_list = PromosLists::where('bar_id', $data['bar_id'])->where('active', 1)->first();
                // Log::channel('orderlog')->info('ORDER promo list  :' . print_r($promo_list, true));

                if ($promo_list) {
                    $stopPromo = strtotime($nowTime) > strtotime($items[$i]['promo_expire']);
                    Log::channel('orderlog')->info('ORDER: ' . $data['order_num'] . ' - promo: ' . $result->short_name
                        . ' - nowTime: ' . $nowTime . ' - promo expire: ' . $items[$i]['promo_expire'] . ' - stop promo: '
                        . (($stopPromo) ? 'true' : 'false'));

                    // Retorna erro se a promoção não estiver no período descontando o stopPromo (microservices.stopPromo - ver .env)
                    if ($stopPromo) {
                        Log::channel('orderlog')->warning('ORDER: ' . $data['order_num'] . ' -  promo: ' . $result->short_name . ' - PROMO INVALIDA');
                        return response()->json([
                            "error" => true,
                            "message" => "A promoção do produto {$result->short_name} expirou!\nRemova este produto da sacola!",
                            "data" => []
                        ], 422);
                    }
                }
            }
            $softDescriptor = $result->soft_descriptor;
        }

        // Buscar dados do usuário para efetuar o pagamento
        $response = Http::acceptJson()
            ->withHeaders([
                'Authorization' => $this->authorization
            ])
            ->get(config('microservices.available.micro_auth.url') . "/me");

        if ($response->status() > 299) {
            Log::channel('orderlog')->error('ORDER: ' . $data['order_num'] . ' - AUTHORIZATION');
            return response()->json([
                "error" => true,
                "message" => "Não foi possível concluir a compra, tente novamente mais tarde!",
                "data" => []
            ], 301);
        }

        $user = json_decode($response->body());
        $user = $user->data;
        // Log::channel('orderlog')->info('ORDER: ' . $data['order_num'] . ' - user infos.: ' . print_r($user, true));

        // Buscar informações do cartão no cofre na GetNet
        $paymentInfo = $data['payment_info'];
        $response = Http::acceptJson()
            ->withHeaders([
                'Authorization' => $this->authorization
            ])
            ->get(config('microservices.available.micro_payment.url') . "/getnet-card/" . $paymentInfo['card_id']);

        if ($response->status() > 299) {
            Log::channel('orderlog')->error('ORDER: ' . $data['order_num'] . ' - GETCARD INFO');
            return response()->json([
                "error" => true,
                "message" => "Não foi possível concluir a compra, tente novamente mais tarde!",
                "data" => []
            ], 301);
        }

        $response = json_decode($response->body());
        $cardInfo = $response->data;
        // Log::channel('orderlog')->info('ORDER: ' . $data['order_num'] . ' - card infos.: ' . print_r($cardInfo, true));

        $fullName = explode(' ', $user->short_name);
        $firstName = $fullName[0];
        $lastName = $fullName[count($fullName) - 1];
        $paymentData = array(
            "barId" => $data['bar_id'],
            "type" =>  $paymentInfo['type'],
            "cardNumber" => $paymentInfo['card_number'],
            "brand" => ucfirst(strtolower($cardInfo->brand)),
            "amount" => $data['total'],
            "orderNum" => $data['order_num'],
            "numberToken" => $cardInfo->number_token,
            "cardHolderName" => $cardInfo->cardholder_name,
            "expirationMonth" => (string) $cardInfo->expiration_month,
            "expirationYear" => (string) $cardInfo->expiration_year,
            "securityCode" => $paymentInfo['security_code'],
            "softDescriptor" => $softDescriptor,
            "clientIdentify" => $user->identify,
            "clientFirstName" => $firstName,
            "clientLastName" => $lastName,
            "clientCpfCnpj" => $user->cpf,
            "clientDocType" => "CPF",
            "clientEmail" => $user->email,
            "clientPhone" => "55" . $user->cell_phone,
            "clientStreet" => $user->street,
            "clientNumber" => $user->number,
            "clientComplement" => $user->complement,
            "clientDistrict" => $user->district,
            "clientCity" => $user->city,
            "clientUF" => $user->state,
            "clientCEP" => preg_replace('/[^0-9]/', '', $user->postal_code),
        );

        Log::channel('orderlog')->info('ORDER: ' . $data['order_num'] . ' - payment data.: ' . print_r($paymentData, true));

        // Efetua o pagamento na Getnet
        $response = Http::timeout(120)
            ->acceptJson()
            ->withHeaders([
                'Authorization' => $this->authorization
            ])
            ->post(config('microservices.available.micro_payment.url') . "/getnet-process-credit", $paymentData);

        if ($response->status() > 299) {
            Log::channel('orderlog')->error('ORDER: ' . $data['order_num'] . ' - PAGAMENTO NÃO PROCESSADO - status code: ' . $response->status());
            return response()->json([
                "error" => true,
                "message" => "Não foi possível concluir a compra, tente novamente mais tarde!",
                "data" => []
            ], $response->status());
        }

        $response = json_decode($response->body());
        $paymentResult = $response->data;
        Log::channel('orderlog')->info('ORDER: ' . $data['order_num'] . ' - payment status: ' . print_r($response, true));

        if ($paymentResult->status == 'APPROVED') {
            Log::channel('orderlog')->info('ORDER: ' . $data['order_num'] . ' - userId: ' . $user->id . ' - SALVAR ORDER');
            $orderId = 0;
            try {
                DB::transaction(function () use ($data, $user, &$orderId) {
                    $order = $this->model->create(array(
                        'bar_id' => $data['bar_id'],
                        'client_id' => $user->id,
                        'client_identify' => $user->identify,
                        'order_num' => $data['order_num'],
                        'total' => $data['total'],
                        'order_at' => $data['order_at'],
                        'inserted_for' => $data['inserted_for'],
                    ));
                    $orderitems = $order->Products()->sync($data['items']);
                    $orderId = $order->id;
                    Log::channel('orderlog')->info('ORDER: orderId' . $orderId . ' - orderItems: ' . print_r($orderitems, true));
                });
            } catch (\Exception $e) {
                Log::channel('orderlog')->error('ORDER: ' . $data['order_num'] . ' - SALVANDO ORDER');
                Log::channel('orderlog')->error('ORDER: ' . $data['order_num'] . ' - ERROR2: ' . print_r($e->getMessage(), true));
                return response()->json([
                    "error" => true,
                    "message" => "Não foi possível concluir a compra, tente novamente mais tarde!",
                    "data" => []
                ], 500);
            }

            Log::channel('orderlog')->info('ORDER: ' . $data['order_num'] . ' - GERAR BARCODE');
            for ($i = 0; $i < count($items); $i++) {
                /**
                 *  Baixar estoque de cada item!
                 */
                Log::channel('orderlog')->info('ORDER: ' . $data['order_num'] . ' - STOCK DECREMENT: ' . $items[$i]['short_name'] . ' qtd: ' . $items[$i]['quantity']);
                try {
                    DB::transaction(function () use ($data, $items, $i) {
                        $stock = DB::table('products')
                            ->where('id', $items[$i]['product_id'])
                            ->decrement('quantity', $items[$i]['quantity']);
                        Log::channel('orderlog')->info('ORDER: ' . $data['order_num'] . ' - Item: ' . $items[$i]['short_name'] . ' result: ' . print_r($stock, true));
                    });
                } catch (\Exception $e) {
                    Log::channel('orderlog')->error('ORDER: ' . $data['order_num'] . ' - AJUSTANDO ESTOQUE');
                    Log::channel('orderlog')->error('ORDER: ' . $data['order_num'] . ' - ERROR: ' . print_r($e->getMessage(), true));
                    return response()->json([
                        "error" => true,
                        "message" => "Não foi possível concluir a compra, tente novamente mais tarde!",
                        "data" => []
                    ], 500);
                }

                for ($j = 0; $j < $items[$i]['quantity']; $j++) {
                    /**
                     * Bar_Code (00-000000-000-0000000-00): order_num - product_id - item
                     *    product_id: 7 caracteres podendo chegar a 9999999 (~ 10 milhões)
                     *    item: 2 caracteres podendo chegar a 99 (~ cem por proudct_id) (se comprar 3 itens do mesmo produto vai de 1-3)
                     */
                    $barcode = $data['order_num'] . '-' . str_pad($items[$i]['product_id'], 7, "0", STR_PAD_LEFT) . '-'
                        . str_pad($j + 1, 2, "0", STR_PAD_LEFT);
                    Log::channel('orderlog')->info(
                        'ORDER: ' . $data['order_num'] . ' - ITEM: ' . str_pad($items[$i]['short_name'], 15, " ", STR_PAD_RIGHT)
                            . ' - BARCODE ITEM: ' . $barcode
                    );

                    // Calcula a validade do barcode data atual + 12 horas
                    $validate = \Carbon\Carbon::now()->addHours(12);
                    $validate = (string) $validate->format('Y-m-d H:i:s');

                    try {
                        DB::transaction(function () use ($user, $data, $items, $orderId, $barcode, $validate, $i) {
                            DB::table('orders_barcodes')->insert(
                                array(
                                    "bar_id" => $data['bar_id'],
                                    "order_id" => $orderId,
                                    "product_id" => $items[$i]['product_id'],
                                    "barcode" => $barcode,
                                    "validate" => $validate,
                                )
                            );
                        });
                    } catch (\Exception $e) {
                        Log::channel('orderlog')->error('ORDER: ' . $data['order_num'] . ' - SALVANDO BARCODE');
                        Log::channel('orderlog')->error('ORDER: ' . $data['order_num'] . ' - ERROR: ' . print_r($e->getMessage(), true));
                        return response()->json([
                            "error" => true,
                            "message" => "Não foi possível concluir a compra, tente novamente mais tarde!",
                            "data" => []
                        ], 500);
                    }
                }
            }
        }

        return response()->json([
            "error" => false,
            "message" => "Created Order!",
            "data" => []
        ], 200);
    }


    public function retornaOrdersParaApi()
    {
    
        
        $orders = DB::table('orders')
            ->select('orders.*')
            // ->leftJoin('bars', 'orders.bar_id', 'bars.id')
            ->where('orders.erp_id',null)
            ->where('orders.post_try', 0)
            ->where('orders.active', 1)
            // ->where('bars.active', 1)
            ->orderBy('orders.id', 'asc')
            ->get();

            if ($orders->isEmpty()) {
                return false;
            }

        foreach ($orders as $order) {
            $items = DB::table('orders_items AS oi')
                ->select(
                    'oi.order_id',
                    'oi.item',
                    'oi.product_id',
                    'p.erp_id',
                    'p.short_name',
                    'p.short_description',
                    'p.marca',
                    'p.unity',
                    'p.image_url',
                    'oi.quantity',
                    'oi.price',
                    'oi.total',
                    'p.price_cost_erp'
                )
                ->leftJoin('products AS p', 'oi.product_id', 'p.id')
                ->where('order_id', $order->id)
                ->orderBy('oi.item', 'asc')
                ->get();

             // Adiciona os itens ao objeto $order    
            $order->items = $items;
       
            $dataFormatada = substr($order->created_at, 0, 10);
                 
          // Cria o array de dados para envio ao SyncVendasJob
            $dados = [
            
                "order_number" => "",
                "order_type" => 1,
                "delivery_time" => $dataFormatada,
                "date_order" => $dataFormatada,
                "customer" => 9285552,
                "validity" => null,
                "canceled" => 0,
                "inutilized" => 0,
                "nfe" => null,
                "fiscal_operation" => 24052,
                "date_billed" => $dataFormatada,
                "contact_name" => "Coelho",
                "seller" => 45574,
                "date_sell" => $dataFormatada,
                "total" => $order->total,
                "idOrder"=> $order->id,
                "sales_parcel_groups" => [
                    [
                        "price" => $order->total,
                        "payment_form" => 59703, //Cartão de Crédito
                        "total_discount" => 0.0,
                        "total_addition" => 0.0
                    ]
                ],
                "sales_parcels" => [
                    [
                        "parcel" => 1,
                        "expiration" => $dataFormatada,
                        "price" => $order->total,
                        "payment_form" => 59703,//Cartão de Crédito
                        "sales_parcel_group" => null
                    ]
                ],
                "sales_items" => [] // Os itens serão adicionados no foreach
            ];
                foreach ($order->items as $item){
                    //... monta o array de cada item ...
                    $dados['sales_items'][] = 
                    [
                            "item_name" => $item->short_name,
                            "price_sell" => $item->price,
                            "price_cost" => $item->price_cost_erp, 
                            "canceled" => 0,
                            "qtd" => $item->quantity,
                            "seller_id" => 12119, //ID consumidor Final
                            "product_id" => $item->erp_id,
                            "item_type" => "product"
                    ];
                    
                }        
           
            // Converte o array de dados em JSON
             $json = json_encode($dados);
            
             // Despacha o job para sincronizar as vendas
            
              SyncVendasJob::dispatch($json); 
             
            }
           
            
            return response()->json([
                "error" => false,
                "message" => "Orders retrieved successfully.",
                "data" => $order,          
            ], 200);
    }

  
}




