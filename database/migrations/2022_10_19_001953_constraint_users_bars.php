<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConstraintUsersBars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_bars', function (Blueprint $table) {
            $table->foreignId('group_id')->nullable()->after('id')->constrained('groups')->onDelete('cascade');
            $table->foreignId('bar_id')->nullable()->after('id')->constrained('bars')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_bars', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropForeign(['bar_id']);
            $table->dropForeign(['user_id']);
        });
    }
}
