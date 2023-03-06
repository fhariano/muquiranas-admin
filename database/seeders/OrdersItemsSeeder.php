<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrdersItems;

class OrdersItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $ordersItems = OrdersItems::create([

            "order_id" => 1,
            "item" => 3 ,
            "product_id" => 1,
            "quantity" => 13 ,
            "price" => 12.00 ,
            "total" => 120.00 ,
        ]);

        $ordersItems = OrdersItems::create([

            "order_id" => 1,
            "item" => 5 ,
            "product_id" => 8,
            "quantity" => 7 ,
            "price" => 7.00 ,
            "total" => 49.00 ,
        ]);
    }
}
