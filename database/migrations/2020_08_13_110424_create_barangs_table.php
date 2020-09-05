<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->increments('id_barang');
            $table->string('kode_barang', 10)->unique();
            $table->string('nama_barang', 50);
            $table->unsignedInteger('jenis_barang_id');
            $table->unsignedInteger('satuan_pembelian_id');
            $table->unsignedInteger('isi');
            $table->unsignedInteger('satuan_penjualan_id');
            $table->unsignedInteger('harga_beli')->nullable();
            $table->unsignedInteger('harga_jual')->nullable();
            $table->unsignedInteger('stok')->nullable();
            $table->timestamps();
        });

        Schema::table('barangs', function (Blueprint $table) {
            $table->foreign('jenis_barang_id')->references('id_jenis_barang')->on('jenis_barangs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('satuan_pembelian_id')->references('id_satuan_pembelian')->on('satuan_pembelians')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('satuan_penjualan_id')->references('id_satuan_penjualan')->on('satuan_penjualans')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}