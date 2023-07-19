<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_permission', function (Blueprint $table) {
            $table->bigIncrements('menu_permission_id');
            $table->unsignedBigInteger('role_menu_id');
            $table->unsignedBigInteger('permission_id');

            $table->foreign('role_menu_id')
                  ->references('role_menu_id')
                  ->on('role_menu')
                  ->onDelete('cascade');

            $table->foreign('permission_id')
                  ->references('permission_id')
                  ->on('permission')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_permission');
    }
}
