<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConstraintOrdersItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders_items', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable()->after('id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->after('item')->constrained('products')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('order_id', 'product_id')) {
            
            Schema::table('orders_items', function (Blueprint $table) {
                $table->dropForeign(['order_id']);
                $table->dropForeign(['product_id']);
            });
        }
    }
}
