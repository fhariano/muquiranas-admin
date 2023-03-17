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
        Schema::disableForeignKeyConstraints();
        Schema::create('orders_items', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('item'); // The signed range is -128 to 127. The unsigned range is 0 to 255
            $table->tinyInteger('quantity'); // The signed range is -128 to 127. The unsigned range is 0 to 255
            $table->double('price', 9,2); // 00.000,00
            $table->double('total', 14,2); // 000.000.000,00
            $table->boolean('promo');
            $table->timestamp('promo_expire')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
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
