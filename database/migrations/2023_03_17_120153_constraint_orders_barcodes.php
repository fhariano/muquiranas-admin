<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConstraintOrdersBarcodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders_barcodes', function (Blueprint $table) {
            $table->foreignId('bar_id')->after('id')->constrained('bars')->onDelete('cascade');
            $table->foreignId('order_id')->after('bar_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->after('order_id')->constrained('products')->onDelete('cascade');
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
        if (Schema::hasColumn('orders_barcodes', 'bar_id')) {
            Schema::table('orders_barcodes', function (Blueprint $table) {
                $table->dropForeign(['bar_id']);
                $table->dropForeign(['order_id']);
                $table->dropForeign(['product_id']);
            });
        }
    }
}
