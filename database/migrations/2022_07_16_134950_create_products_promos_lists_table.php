<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsPromosListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_promos_lists', function (Blueprint $table) {
            $table->id();
            $table->time('hour_start');
            $table->time('hour_end');
            $table->decimal('price',$precision=8,$scale=2);
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('products_promos_lists');
    }
}
