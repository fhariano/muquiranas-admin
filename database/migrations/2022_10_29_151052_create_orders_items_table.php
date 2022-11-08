<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_items', function (Blueprint $table) {
            $table->id();
            $table->string('order_id',12);
            $table->tinyInteger('item'); // The signed range is -128 to 127. The unsigned range is 0 to 255
            $table->tinyInteger('quantity'); // The signed range is -128 to 127. The unsigned range is 0 to 255
            $table->double('price', 9,2); // 00.000,00
            $table->double('total', 14,2); // 000.000.000,00
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_items');
    }
}
