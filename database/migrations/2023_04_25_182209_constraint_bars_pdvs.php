<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConstraintBarsTotems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bars_pdvs', function (Blueprint $table) {
            $table->foreignId('bar_id')->after('id')->constrained('bars')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('bars_pdvs', 'bar_id')) {
            Schema::table('bars_pdvs', function (Blueprint $table) {
                $table->dropForeign(['bar_id']);
            });
        }
    }
}
