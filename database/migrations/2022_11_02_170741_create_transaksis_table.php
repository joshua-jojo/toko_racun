<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->bigInteger('jumlah');
            $table->bigInteger('total');
            $table->bigInteger('diskon');
            $table->bigInteger('ppn');
            $table->bigInteger('ppn_total');
            $table->bigInteger('grand_total');
            $table->string('jenis_pembayaran');
            $table->string('no_transaksi')->nullable();
            $table->bigInteger('bayar');
            $table->bigInteger('kembalian');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};
