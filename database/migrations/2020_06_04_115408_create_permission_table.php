<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission', function (Blueprint $table) {
            $table->bigIncrements('permission_id');
            $table->string('permission_name');
            $table->string('permission_action');
            $table->string('description');
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
        Schema::dropIfExists('permission');
    }
}
