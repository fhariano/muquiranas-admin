<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->constrained('resources');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('permissions_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('permission_id')->constrained('permissions');
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
        Schema::dropIfExists('permissions_groups');
        Schema::dropIfExists('permissions');
    }
}
