<?php

namespace Database\Seeders;

use App\Models\ProductsPromosLists;
use Illuminate\Database\Seeder;

class ProductsPromosListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promos = ProductsPromosLists::create([
            "promos_list_id" => 1,
            "product_id" => 1,
            "hour_start" => "14:00", 
            "hour_end" => "14:59",
            "price" => 8.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 1,
            "product_id" => 1,
            "hour_start" => "15:00", 
            "hour_end" => "15:59",
            "price" => 9.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 1,
            "product_id" => 1,
            "hour_start" => "16:00", 
            "hour_end" => "16:59",
            "price" => 10.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 1,
            "product_id" => 1,
            "hour_start" => "17:00", 
            "hour_end" => "19:59",
            "price" => 11.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 1,
            "product_id" => 2,
            "hour_start" => "14:00", 
            "hour_end" => "14:59",
            "price" => 5.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 1,
            "product_id" => 2,
            "hour_start" => "15:00", 
            "hour_end" => "15:59",
            "price" => 6.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 1,
            "product_id" => 2,
            "hour_start" => "16:00", 
            "hour_end" => "16:59",
            "price" => 7.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 1,
            "product_id" => 2,
            "hour_start" => "17:00", 
            "hour_end" => "17:59",
            "price" => 7.50, 
            "inserted_for" => "Flavio Ariano",
        ]);
		$promos->create([
            "promos_list_id" => 2,
            "product_id" => 1,
            "hour_start" => "14:00", 
            "hour_end" => "14:59",
            "price" => 8.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 2,
            "product_id" => 1,
            "hour_start" => "15:00", 
            "hour_end" => "15:59",
            "price" => 9.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 2,
            "product_id" => 1,
            "hour_start" => "16:00", 
            "hour_end" => "16:59",
            "price" => 10.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 2,
            "product_id" => 1,
            "hour_start" => "17:00", 
            "hour_end" => "17:59",
            "price" => 11.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 2,
            "product_id" => 2,
            "hour_start" => "14:00", 
            "hour_end" => "14:59",
            "price" => 5.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 2,
            "product_id" => 2,
            "hour_start" => "15:00", 
            "hour_end" => "15:59",
            "price" => 6.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 2,
            "product_id" => 2,
            "hour_start" => "16:00", 
            "hour_end" => "16:59",
            "price" => 7.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 2,
            "product_id" => 2,
            "hour_start" => "17:00", 
            "hour_end" => "17:59",
            "price" => 7.50, 
            "inserted_for" => "Flavio Ariano",
        ]);
		$promos->create([
            "promos_list_id" => 3,
            "product_id" => 1,
            "hour_start" => "14:00", 
            "hour_end" => "14:59",
            "price" => 8.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 3,
            "product_id" => 1,
            "hour_start" => "15:00", 
            "hour_end" => "15:59",
            "price" => 9.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 3,
            "product_id" => 1,
            "hour_start" => "16:00", 
            "hour_end" => "16:59",
            "price" => 10.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 3,
            "product_id" => 1,
            "hour_start" => "17:00", 
            "hour_end" => "17:59",
            "price" => 11.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 3,
            "product_id" => 2,
            "hour_start" => "14:00", 
            "hour_end" => "14:59",
            "price" => 5.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 3,
            "product_id" => 2,
            "hour_start" => "15:00", 
            "hour_end" => "15:59",
            "price" => 6.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 3,
            "product_id" => 2,
            "hour_start" => "16:00", 
            "hour_end" => "16:59",
            "price" => 7.00, 
            "inserted_for" => "Flavio Ariano",
        ]);
        $promos->create([
            "promos_list_id" => 3,
            "product_id" => 2,
            "hour_start" => "17:00", 
            "hour_end" => "17:59",
            "price" => 7.50, 
            "inserted_for" => "Flavio Ariano",
        ]);
    }
}
