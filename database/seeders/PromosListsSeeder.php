<?php

namespace Database\Seeders;

use App\Models\PromosLists;
use Illuminate\Database\Seeder;

class PromosListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists = PromosLists::create([
            "bar_id" => 1,
            "name" => "Segunda a Sexta",
            "inserted_for" => "Flavio Ariano",
        ]);
        $lists->create([
            "bar_id" => 1,
            "name" => "Sábado",
            "inserted_for" => "Flavio Ariano",
        ]);
        $lists->create([
            "bar_id" => 1,
            "name" => "Domingo",
            "inserted_for" => "Flavio Ariano",
        ]);
    }
}
