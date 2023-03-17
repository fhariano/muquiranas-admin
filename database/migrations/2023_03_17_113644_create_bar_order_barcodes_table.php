<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bar_order_barcodes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id');
            $table->uuid('client_identify');
            $table->string('barcode',45);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('validate')->nullable();
            $table->timestamp('used_at')->useCurrentOnUpdate()->nullable();
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bar_order_barcodes');
    }
};
