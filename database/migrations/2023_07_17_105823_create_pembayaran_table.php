<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('pembayaran_id');
            $table->unsignedBigInteger('tagihan_id');
            $table->date('tgl_pembayaran')->nullable();
            $table->integer('biaya_admin');
            $table->integer('total_bayar');
            $table->integer('pelanggan_bayar')->nullable();
            $table->timestamps();

            $table->foreign('tagihan_id')->references('tagihan_id')->on('tagihan')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}
