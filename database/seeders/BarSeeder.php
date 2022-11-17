<?php

namespace Database\Seeders;

use App\Models\Bars;
use Illuminate\Database\Seeder;

class BarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bars = Bars::create(
            [
                "erp_id" => 1,
                "erp_token" => "04d1be2fd17ba6769bbf",
                "cnpj" => "36288075000167",
                "name" => "Muquiranas Santo André",
                "short_name" => "Santo André",
                "address" => "R. das Figueiras, 130 - Jardim",
                "number" => "130",
                "complement" => "Principal",
                "city_state" => "Santo André/SP",
                "googleMaps_url" => "https://goo.gl/maps/qKnMKhkErpV7RbhC6",
                "image_url" => "https://ws.ri2b.com.br/flutter-imgs/logo.png",
                "start_at" => "14:00",
                "end_at" => "4:00",
                "order" => 1,
                "inserted_for" => "Flavio Ariano",
            ]);
            $bars->create([
                "erp_id" => 2,
                "erp_token" => "04d1be2fd17ba6769bbf",
                "cnpj" => "36288075000168",
                "name" => "Muquiranas Ribeirão Preto",
                "short_name" => "Ribeirão Preto",
                "address" => "R. das Figueiras, 130 - Jardim",
                "number" => "130",
                "complement" => "Principal",
                "city_state" => "Ribeirão Preto/SP",
                "googleMaps_url" => "https://goo.gl/maps/qKnMKhkErpV7RbhC6",
                "image_url" => "https://ws.ri2b.com.br/flutter-imgs/logo.png",
                "start_at" => "14:00",
                "end_at" => "4:00",
                "order" => 2,
                "inserted_for" => "Flavio Ariano",
            ],
        );
    }
}
