<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bars', function (Blueprint $table) {
            $table->id();
            $table->integer('erp_id')->nullable();
            $table->string('name',120);
            $table->string('short_name',45);
            $table->string('address',60);
            $table->string('city_state',60);
            $table->string('cep',8)->nullable();
            $table->string('image_url',255)->nullable();
            $table->time('start_at');
            $table->time('end_at');
            $table->tinyInteger('order');
            $table->boolean('active')->default(true);
            $table->string('inserted_for',45);
            $table->string('updated_for',45)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bars');
    }
}
