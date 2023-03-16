<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder;
use App\Models\Orders;
use App\Models\ProductsPromosLists;
use App\Models\PromosLists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($user_id, $bar_id)
    {
        $orders = DB::table('orders')
            ->select('orders.*')
            ->leftJoin('bars', 'orders.bar_id', 'bars.id')
            ->where('orders.customer_id', $user_id)
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
            $items = DB::table('orders_items AS oItems')
                ->select(
                    'oItems.order_id',
                    'oItems.item',
                    'oItems.product_id',
                    'p.erp_id',
                    'p.short_name',
                    'p.short_description',
                    'p.marca',
                    'p.unity',
                    'p.image_url',
                    'oItems.quantity',
                    'oItems.price',
                    'oItems.total'
                )
                ->leftJoin('products AS p', 'oItems.product_id', 'p.id')
                ->where('order_id', $order->id)
                ->orderBy('oItems.item', 'asc')
                ->get();

            foreach ($items as $item) {
                $order->items[] = $item;
            }
        }

        return response()->json([
            "error" => false,
            "message" => "Lista de orders!",
            "data" => $orders,
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
            $items = DB::table('orders_items AS oItems')
                ->select(
                    'oItems.order_id',
                    'oItems.item',
                    'oItems.product_id',
                    'p.erp_id',
                    'p.short_name',
                    'p.short_description',
                    'p.marca',
                    'p.unity',
                    'p.image_url',
                    'oItems.quantity',
                    'oItems.price',
                    'oItems.total'
                )
                ->leftJoin('products AS p', 'oItems.product_id', 'p.id')
                ->where('order_id', $order->id)
                ->orderBy('oItems.item', 'asc')
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
            // Log::channel('muquiranas')->info('ORDER item:' . print_r($items[$i], true));

            $result = DB::table('bars as b')
                ->leftJoin('products as p', 'b.id', '=', 'p.bar_id')
                ->where('b.id', $data['bar_id'])
                ->where('p.id', $items[$i]['product_id'])
                ->select('b.soft_descriptor', 'p.*')
                ->first();

            if (!$result) {
                // Retorna erro se o produto não está mais no cardápio ou sem estoque!
                Log::channel('muquiranas')->warning('ORDER: ' . $data['order_num'] . ' - stock: ' . $items[$i]['short_name'] . -'FORA DO CARDÁPIO');
                return response()->json([
                    "error" => true,
                    "message" => "O produto {$data['short_name']} não está mais no cardápio!\nRemova este produto da sacola!",
                    "data" => []
                ], 422);
            }

            Log::channel('muquiranas')->info('ORDER estoque result  :' . print_r($result, true));
            Log::channel('muquiranas')->info('ORDER: ' . $data['order_num'] . ' - stock: ' . $result->short_name . ' - item qtd: '
                . $items[$i]['quantity'] . ' - stock qtd: ' . $result->quantity . ' - min qtd: ' . config('microservices.minStock')
                . ' - app price: ' . $items[$i]['price']);

            // Retorna erro se o produto está abaixo do estoque mínimo (microservices.minStock - ver .env)
            if ($result->quantity < config('microservices.minStock')) {
                Log::channel('muquiranas')->warning('ORDER: ' . $data['order_num'] . ' - stock: ' . $result->short_name . -'SEM ESTOQUE');
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
                // Log::channel('muquiranas')->info('ORDER promo list  :' . print_r($promo_list, true));

                if ($promo_list) {
                    $stopPromo = strtotime($nowTime) > strtotime($items[$i]['promo_expire']);
                    Log::channel('muquiranas')->info('ORDER: ' . $data['order_num'] . ' - promo: ' . $result->short_name
                        . ' - nowTime: ' . $nowTime . ' - promo expire: ' . $items[$i]['promo_expire'] . ' - stop promo: '
                        . (($stopPromo) ? 'true' : 'false'));

                    // Retorna erro se a promoção não estiver no período descontando o stopPromo (microservices.stopPromo - ver .env)
                    if ($stopPromo) {
                        Log::channel('muquiranas')->warning('ORDER: ' . $data['order_num'] . ' -  promo: ' . $result->short_name . ' - PROMO INVALIDA');
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
            Log::channel('muquiranas')->error('ORDER: ' . $data['order_num'] . ' - AUTHORIZATION');
            return response()->json([
                "error" => true,
                "message" => "Não foi possível concluir a compra, tente novamente mais tarde!",
                "data" => []
            ], 301);
        }

        $user = json_decode($response->body());
        $user = $user->data;
        // Log::channel('muquiranas')->info('ORDER: ' . $data['order_num'] . ' - user infos.: ' . print_r($user, true));

        // Buscar informações do cartão no cofre na GetNet
        $paymentInfo = $data['payment_info'];
        $response = Http::acceptJson()
            ->withHeaders([
                'Authorization' => $this->authorization
            ])
            ->get(config('microservices.available.micro_payment.url') . "/getnet-card/" . $paymentInfo['card_id']);

        if ($response->status() > 299) {
            Log::channel('muquiranas')->error('ORDER: ' . $data['order_num'] . ' - GETCARD INFO');
            return response()->json([
                "error" => true,
                "message" => "Não foi possível concluir a compra, tente novamente mais tarde!",
                "data" => []
            ], 301);
        }

        $response = json_decode($response->body());
        $cardInfo = $response->data;
        // Log::channel('muquiranas')->info('ORDER: ' . $data['order_num'] . ' - card infos.: ' . print_r($cardInfo, true));

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

        Log::channel('muquiranas')->info('ORDER: ' . $data['order_num'] . ' - payment data.: ' . print_r($paymentData, true));

        // Efetua o pagamento na Getnet
        $response = Http::acceptJson()
            ->withHeaders([
                'Authorization' => $this->authorization
            ])
            ->post(config('microservices.available.micro_payment.url') . "/getnet-process-credit", $paymentData);

        $response = json_decode($response->body());
        Log::channel('muquiranas')->info('ORDER: ' . $data['order_num'] . ' - payment result.: ' . print_r($response, true));


        // $order = $this->model->create([
        //     'bar_id' => $data['bar_id'],
        //     'customer_id' => $data['customer_id'],
        //     'order_num' => $data['order_num'],
        //     'total' => $data['total'],
        //     'order_at' => $data['order_at'],
        //     'inserted_for' => $data['inserted_for'],
        // ]);

        // $items = $order->Products()->sync($data['items']);

        return response()->json([
            "error" => false,
            "message" => "Created Order!",
            "data" => []
        ], 200);
    }
}
