<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id('tagihan_id');
            $table->unsignedBigInteger('penggunaan_id');
            $table->unsignedBigInteger('pelanggan_id');
            $table->string('jmlh_meter', 10);
            $table->integer('status');
            $table->date('waktu_tagihan');
            $table->timestamps(); 

            $table->foreign('penggunaan_id')->references('penggunaan_id')->on('penggunaan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pelanggan_id')->references('pelanggan_id')->on('pelanggan')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagihan');
    }
}
