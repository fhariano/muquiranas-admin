<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Categories::create([
            "bar_id" => 1,
            "erp_id" => 536095,
            "name" => "Cervejas",
            "icon_data" => "0xe5e4",
            "icon_name" => "sports_bar",
            "order" => 1,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 1,
            "erp_id" => 535828,
            "name" => "Drinks e Doses",
            "icon_data" => "0xe38c",
            "icon_name" => "local_bar",
            "order" => 2,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 1,
            "name" => "Não Alcoólicos",
            "erp_id" => 5360941,
            "icon_data" => "0xe6f1",
            "icon_name" => "wine_bar",
            "order" => 3,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 1,
            "name" => "Garrafas",
            "erp_id" => 535145,
            "icon_data" => "0xe383",
            "icon_name" => "liquor",
            "order" => 4,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 1,
            "erp_id" => 535830,
            "name" => "Comidinhas",
            "icon_data" => "0xe532",
            "icon_name" => "restaurant",
            "order" => 5,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 1,
            "erp_id" => 535831,
            "name" => "Combos e Pra Levar",
            "icon_data" => "0xe1bd",
            "icon_name" => "delivery_dining",
            "order" => 6,
            "inserted_for" => "Flavio Ariano",
        ]);
		$categories->create([
            "bar_id" => 2,
            "erp_id" => 536095,
            "name" => "Cervejas",
            "icon_data" => "0xe5e4",
            "order" => 1,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 2,
            "erp_id" => 535828,
            "name" => "Drinks e Doses",
            "icon_data" => "0xe38c",
            "order" => 2,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 2,
            "erp_id" => 5360941,
            "name" => "Não Alcoólicos",
            "icon_data" => "0xe6f1",
            "order" => 3,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 2,
            "erp_id" => 535145,
            "name" => "Garrafas",
            "icon_data" => "0xe383",
            "order" => 4,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 2,
            "erp_id" => 535830,
            "name" => "Comidinhas",
            "icon_data" => "0xe532",
            "order" => 5,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 2,
            "erp_id" => 535831,
            "name" => "Combos e Pra Levar",
            "icon_data" => "0xe1bd",
            "order" => 6,
            "inserted_for" => "Flavio Ariano",
        ]);
    }
}
