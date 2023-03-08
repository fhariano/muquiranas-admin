<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('erp_id')->nullable();
            $table->string('ean_erp',255)->nullable();
            $table->string('name',255)->nullable();
            $table->string('short_name',60)->default("PRODUTO NOVO")->nullable();
            $table->string('short_description',45)->default("")->nullable();
            $table->string('marca',45)->default("")->nullable();
            $table->string('unity',20)->default("")->nullable();
            $table->decimal('price_cost_erp',$precision=8, $scale=2)->default(0.00);
            $table->decimal('price_sell_erp',$precision=8, $scale=2)->default(0.00);
            $table->decimal('price_base',$precision=8, $scale=2)->default(0.00);
            $table->string('image_url',255)->default("")->nullable();
            $table->integer('order')->default(0);
            $table->boolean('promo')->default(false);
            $table->decimal('promo_price',$precision=8, $scale=2)->default(0.00);
            $table->char('promo_expire',8)->default("00:00:00");
            $table->char('now_time',8)->default("00:00:00");
            $table->boolean('active')->default(true);
            $table->string('inserted_for',45)->nullable();
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
        Schema::dropIfExists('products');
    }
}
