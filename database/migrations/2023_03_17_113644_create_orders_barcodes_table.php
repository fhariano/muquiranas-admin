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
        Schema::disableForeignKeyConstraints();
        Schema::create('orders_barcodes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id');
            $table->uuid('client_identify');
            $table->string('barcode',45)->unique();
            $table->timestamp('validate')->nullable();
            $table->timestamp('used_at')->useCurrentOnUpdate()->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
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
        Schema::dropIfExists('orders_barcodes');
    }
};
