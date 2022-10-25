<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConstraintProductsPromosListProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::table('products_promos_lists', function (Blueprint $table) {
            $table->foreignId('product_id')->after('promos_list_id')->constrained('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_promos_lists', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });
    }
}
