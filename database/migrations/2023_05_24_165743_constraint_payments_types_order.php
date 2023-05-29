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
        {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('payment_type ')->nullable()->after('invoice')->constrained('payments_types')->onDelete('cascade');
            });
            Schema::enableForeignKeyConstraints();
        }
        
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        if (Schema::hasColumn('orders', 'payment_type ')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['payment_type ']);
            });
        }
    }
};
