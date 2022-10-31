<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Products::create([
            "bar_id" => 1,
            "category_id" => 1,
            "erp_id" => 7583007,
            "ean_erp" => "7891149101900",
            "name" => "STELLA ARTOIS LONG NECK 330ML",
            "short_name" => "STELLA ARTOIS",
            "short_description" => "LONG NECK",
            "marca" => "Stella",
            "unity" => "330ML",
            "price_cost_erp" => 6.00,
            "price_base" => 12.00,
            "image_url" => "https://s3-sa-east-1.amazonaws.com/cake-app-files/public/customers/11083/products/7583007/thumb/d7e95e59-3e56-49d6-8f4c-809a597499f6.png",
            "order" => 1,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 1,
            "category_id" => 1,
            "erp_id" => 7541193,
            "ean_erp" => "7891149030309",
            "name" => "CERVEJA BRAHMA CHOPP LONG NECK 355ML",
            "short_name" => "BRAHMA CHOPP",
            "short_description" => "LONG NECK",
            "marca" => "Brahma",
            "unity" => "355ML",
            "price_cost_erp" => 4.00,
            "price_sell_erp" => 6.00,
            "price_base" => 8.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/brahma.png",
            "order" => 2,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 1,
            "category_id" => 2,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "TEQUILA JOSE CUERVO ESP REP",
            "short_name" => "TEQUILA JOSE CUERVO",
            "short_description" => "DOSE",
            "marca" => "JOSE CUERVO",
            "unity" => "50ML",
            "price_cost_erp" => 8.00,
            "price_sell_erp" => 12.00,
            "price_base" => 18.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/tequila-shot.png",
            "order" => 1,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 2,
            "category_id" => 1,
            "erp_id" => 7583007,
            "ean_erp" => "7891149101900",
            "name" => "STELLA ARTOIS LONG NECK 330ML",
            "short_name" => "STELLA ARTOIS",
            "short_description" => "LONG NECK",
            "marca" => "Stella",
            "unity" => "330ML",
            "price_cost_erp" => 6.00,
            "price_base" => 12.00,
            "image_url" => "https://s3-sa-east-1.amazonaws.com/cake-app-files/public/customers/11083/products/7583007/thumb/d7e95e59-3e56-49d6-8f4c-809a597499f6.png",
            "order" => 2,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 2,
            "category_id" => 1,
            "erp_id" => 7541193,
            "ean_erp" => "7891149030309",
            "name" => "CERVEJA BRAHMA CHOPP LONG NECK 355ML",
            "short_name" => "BRAHMA CHOPP",
            "short_description" => "LONG NECK",
            "marca" => "Brahma",
            "unity" => "355ML",
            "price_cost_erp" => 4.00,
            "price_sell_erp" => 6.00,
            "price_base" => 8.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/brahma.png",
            "order" => 1,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 2,
            "category_id" => 2,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "TEQUILA JOSE CUERVO ESP REP",
            "short_name" => "TEQUILA JOSE CUERVO",
            "short_description" => "DOSE",
            "marca" => "JOSE CUERVO",
            "unity" => "50ML",
            "price_cost_erp" => 8.00,
            "price_sell_erp" => 12.00,
            "price_base" => 18.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/tequila-shot.png",
            "order" => 1,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 1,
            "category_id" => 1,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "BRAHMA EXTRA WEISS",
            "short_name" => "BRAHMA EXTRA WEISS",
            "short_description" => "LONG NECK",
            "marca" => "",
            "unity" => "355ML",
            "price_cost_erp" => 5.00,
            "price_sell_erp" => 8.00,
            "price_base" => 8.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/brahmaextra-weiss.png",
            "order" => 3,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 1,
            "category_id" => 1,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "CERVEJA SKOL",
            "short_name" => "SKOL",
            "short_description" => "LONG NECK",
            "marca" => "",
            "unity" => "355ML",
            "price_cost_erp" => 2.00,
            "price_sell_erp" => 4.00,
            "price_base" => 4.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/skol.png",
            "order" => 4,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 1,
            "category_id" => 1,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "CERVEJA BECKS",
            "short_name" => "BECKS",
            "short_description" => "LONG NECK",
            "marca" => "",
            "unity" => "330ML",
            "price_cost_erp" => 5.00,
            "price_sell_erp" => 8.00,
            "price_base" => 9.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/becks.png",
            "order" => 5,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 1,
            "category_id" => 2,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "CAIPIRINHA",
            "short_name" => "CAIPIRINHA",
            "short_description" => "Pinga, Limão e Açúcar",
            "marca" => "",
            "unity" => "200ML",
            "price_cost_erp" => 6.00,
            "price_sell_erp" => 10.00,
            "price_base" => 12.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/caipirinha.png",
            "order" => 2,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 1,
            "category_id" => 3,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "AGUÁ S/ GÁS",
            "short_name" => "AGUÁ S/ GÁS",
            "short_description" => "",
            "marca" => "Minalba",
            "unity" => "500ML",
            "price_cost_erp" => 2.00,
            "price_sell_erp" => 3.00,
            "price_base" => 3.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/agua-sem-gas.png",
            "order" => 1,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 1,
            "category_id" => 4,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "WHISKY JACK DANIEL'S",
            "short_name" => "WHISKY JACK DANIEL'S",
            "short_description" => "12 anos",
            "marca" => "JACK DANIEL'S",
            "unity" => "1000ML",
            "price_cost_erp" => 98.00,
            "price_sell_erp" => 125.00,
            "price_base" => 150.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/jack-daniels-garrafa.png",
            "order" => 1,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 1,
            "category_id" => 5,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "MINI PASTÉIS",
            "short_name" => "MINI PASTÉIS",
            "short_description" => "Porção",
            "marca" => "MASSA LEVE",
            "unity" => "10 un",
            "price_cost_erp" => 6.60,
            "price_sell_erp" => 10.00,
            "price_base" => 15.90,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/mini-pasteis.png",
            "order" => 1,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 1,
            "category_id" => 6,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "CERVEJA CORONA PACK 6 UN",
            "short_name" => "CERVEJA CORONA",
            "short_description" => "PACK C/ 6",
            "marca" => "CORONA",
            "unity" => "6 un",
            "price_cost_erp" => 18.00,
            "price_sell_erp" => 22.00,
            "price_base" => 28.90,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/corona-pack.png",
            "order" => 1,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 2,
            "category_id" => 7,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "BRAHMA EXTRA WEISS",
            "short_name" => "BRAHMA EXTRA WEISS",
            "short_description" => "LONG NECK",
            "marca" => "",
            "unity" => "355ML",
            "price_cost_erp" => 5.00,
            "price_sell_erp" => 8.00,
            "price_base" => 8.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/brahmaextra-weiss.png",
            "order" => 3,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 2,
            "category_id" => 7,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "CERVEJA SKOL",
            "short_name" => "SKOL",
            "short_description" => "LONG NECK",
            "marca" => "",
            "unity" => "355ML",
            "price_cost_erp" => 2.00,
            "price_sell_erp" => 4.00,
            "price_base" => 4.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/skol.png",
            "order" => 4,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 2,
            "category_id" => 7,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "CERVEJA BECKS",
            "short_name" => "BECKS",
            "short_description" => "LONG NECK",
            "marca" => "",
            "unity" => "330ML",
            "price_cost_erp" => 5.00,
            "price_sell_erp" => 8.00,
            "price_base" => 9.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/becks.png",
            "order" => 5,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 2,
            "category_id" => 8,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "CAIPIRINHA",
            "short_name" => "CAIPIRINHA",
            "short_description" => "Pinga, Limão e Açúcar",
            "marca" => "",
            "unity" => "200ML",
            "price_cost_erp" => 6.00,
            "price_sell_erp" => 10.00,
            "price_base" => 12.00,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/caipirinha.png",
            "order" => 2,
            "inserted_for" => "Flavio Ariano",
        ]);
        $products->create([
            "bar_id" => 2,
            "category_id" => 12,
            "erp_id" => 7611928,
            "ean_erp" => "7501035010109",
            "name" => "CERVEJA CORONA PACK 6 UN",
            "short_name" => "CERVEJA CORONA",
            "short_description" => "PACK C/ 6",
            "marca" => "CORONA",
            "unity" => "6 un",
            "price_cost_erp" => 18.00,
            "price_sell_erp" => 22.00,
            "price_base" => 28.90,
            "image_url" => "https://ws.ri2b.com.br/flutter-imgs/corona-pack.png",
            "order" => 1,
            "inserted_for" => "Flavio Ariano",
        ]);
    }
}
