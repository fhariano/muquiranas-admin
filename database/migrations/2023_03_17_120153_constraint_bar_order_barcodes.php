<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConstraintBarOrderBarcodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bar_order_barcodes', function (Blueprint $table) {
            $table->foreignId('bar_id')->after('id')->constrained('bars')->onDelete('cascade');
            $table->foreignId('order_id')->after('bar_id')->constrained('bars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bar_order_barcodes', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['bar_id']);
        });
    }
}
