<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusFieldTableBars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bars', function (Blueprint $table) {
            $table->boolean('status')
            ->nullable()
            ->after('active')
            ->default(false);
               
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bars', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
