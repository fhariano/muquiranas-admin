<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConstraintPromosListsBars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promos_lists', function (Blueprint $table) {
            $table->foreignId('bar_id')->after('id')->constrained('bars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promos_lists', function (Blueprint $table) {
            $table->dropForeign(['bar_id']);
        });
    }
}
