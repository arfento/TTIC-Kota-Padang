<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->increments('id_detail_penjualan');
            $table->unsignedInteger('penjualan_id');
            $table->unsignedInteger('barang_id');
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('harga_satuan');
        
           
            $table->foreign('barang_id')->references('id_barang')->on('barangs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('penjualan_id')->references('id_penjualan')->on('penjualans')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_penjualans');
    }
}
