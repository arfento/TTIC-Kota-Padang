<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->bigIncrements('id_penjualan');
            $table->string('nomor_faktur', 10)->unique();
            $table->date('tanggal');
            $table->unsignedBigInteger('total');
            $table->unsignedBigInteger('user_id');

            $table->string('user_nama', 100);
            $table->string('user_nohp', 15);
            $table->text('user_alamat');
            $table->timestamps();
        });

        Schema::table('penjualans', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}
