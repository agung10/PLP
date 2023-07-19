<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penggunaan', function (Blueprint $table) {
            $table->id('penggunaan_id');
            $table->unsignedBigInteger('pelanggan_id');
            $table->date('waktu');
            $table->string('meter_awal', 10);
            $table->string('meter_akhir', 10);
            $table->timestamps();

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
        Schema::dropIfExists('penggunaan');
    }
}
