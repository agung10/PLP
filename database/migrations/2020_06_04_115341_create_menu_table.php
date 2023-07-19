<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('menu_id');
            $table->string('name');
            $table->string('route')->nullable();
            $table->integer('id_parent')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order');
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at', 0)->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('updated_at', 0)->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('deleted_at', 0)->nullable();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
