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
            $table->increments('id_persediaan');
            $table->unsignedInteger('rak_id');
            $table->unsignedInteger('barang_id');
            $table->unsignedInteger('stok');
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
