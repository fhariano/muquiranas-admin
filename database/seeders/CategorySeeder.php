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
            "erp_id" => 536094,
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
            "icon_name" => "sports_bar",
            "order" => 1,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 2,
            "erp_id" => 535828,
            "name" => "Drinks e Doses",
            "icon_data" => "0xe38c",
            "icon_name" => "local_bar",
            "order" => 2,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 2,
            "name" => "Não Alcoólicos",
            "erp_id" => 536094,
            "icon_data" => "0xe6f1",
            "icon_name" => "wine_bar",
            "order" => 3,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 2,
            "name" => "Garrafas",
            "erp_id" => 535145,
            "icon_data" => "0xe383",
            "icon_name" => "liquor",
            "order" => 4,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 2,
            "erp_id" => 535830,
            "name" => "Comidinhas",
            "icon_data" => "0xe532",
            "icon_name" => "restaurant",
            "order" => 5,
            "inserted_for" => "Flavio Ariano",
        ]);
        $categories->create([
            "bar_id" => 2,
            "erp_id" => 535831,
            "name" => "Combos e Pra Levar",
            "icon_data" => "0xe1bd",
            "icon_name" => "delivery_dining",
            "order" => 6,
            "inserted_for" => "Flavio Ariano",
        ]);
    }
}
