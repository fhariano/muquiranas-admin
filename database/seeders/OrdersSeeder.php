<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Orders;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    
            $orders = Orders::create([

                "bar_id" => 1,
                "customer_id" => 4,
                "order_num" => 5,
                "erp_id" => null,
                "invoice" => null,
                "total" => 169.00,
                "order_at" => "2023-02-02 19:56:02",
                "inserted_for" => "2023-02-02 19:56:02",
                "updated_for" => null,
                "billed" => 0,
                "active" => 1,
            ]);
    }
}
