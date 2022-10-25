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
                "name" => "Muquiranas Santo André",
                "short_name" => "Santo André",
                "address" => "R. das Figueiras, 130 - Jardim",
                "city_state" => "Santo André/SP",
                "image_url" => "https://ws.ri2b.com.br/flutter-imgs/logo.png",
                "start_at" => "14:00",
                "end_at" => "4:00",
                "order" => 1,
                "inserted_for" => "Flavio Ariano",
            ]);
            $bars->create([
                "erp_id" => 2,
                "name" => "Muquiranas Ribeirão Preto",
                "short_name" => "Ribeirão Preto",
                "address" => "R. das Figueiras, 130 - Jardim",
                "city_state" => "Ribeirão Preto/SP",
                "image_url" => "https://ws.ri2b.com.br/flutter-imgs/logo.png",
                "start_at" => "14:00",
                "end_at" => "4:00",
                "order" => 2,
                "inserted_for" => "Flavio Ariano",
            ],
        );
    }
}
