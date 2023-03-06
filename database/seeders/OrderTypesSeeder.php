<?php

namespace Database\Seeders;
use App\Models\OrderType;  

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderType = OrderType::create([

            "erp_id" => 1,
            "name" => "Vendas",
            "inserted_for" => "Murilo",
          
        ]);
        $orderType = OrderType::create([

            "erp_id" => 2,
            "name" => "Faturar",
            "inserted_for" => "Murilo",
    
        ]);
        $orderType = OrderType::create([

            "erp_id" => 3,
            "name" => "Cancelado",
            "inserted_for" => "Murilo",
       
        ]);

    }
}
