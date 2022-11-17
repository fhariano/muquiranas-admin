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
        Schema::create('bars_history', function (Blueprint $table) {
            $table->id();
            $table->integer('bar_id');
            $table->integer('user_id');
            $table->string('name',120);
            $table->string('action',60);
            $table->string('inserted_for',60);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bars_history');
    }
};
