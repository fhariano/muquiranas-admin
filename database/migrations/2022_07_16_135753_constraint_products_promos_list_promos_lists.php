<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConstraintProductsPromosListPromosLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_promos_lists', function (Blueprint $table) {
            $table->foreignId('promos_list_id')->after('id')->constrained('promos_lists')->onDelete('cascade');
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
            $table->dropForeign(['promos_list_id']);
        });
    }
}
