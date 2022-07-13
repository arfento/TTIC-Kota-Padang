<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pembelians', function (Blueprint $table) {
            $table->BigIncrements('id_detail_pembelian');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('pembelian_id');
            $table->unsignedBigInteger('jumlah');
            $table->unsignedBigInteger('harga_satuan');
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->timestamps();
        });

        Schema::table('detail_pembelians', function (Blueprint $table) {
           
            $table->foreign('barang_id')->references('id_barang')->on('barangs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pembelian_id')->references('id_pembelian')->on('pembelians')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pembelians');
    }
}
