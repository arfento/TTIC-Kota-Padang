<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersediaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persediaans', function (Blueprint $table) {
            $table->bigIncrements('id_persediaan');
            $table->unsignedBigInteger('rak_id');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('stok');
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->timestamps();
        
            $table->foreign('barang_id')->references('id_barang')->on('barangs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('rak_id')->references('id_rak')->on('raks')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persediaans');
    }
}
