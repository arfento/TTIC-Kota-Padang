<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->bigIncrements('id_shipment');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('penjualan_id');
            $table->string('track_number',50)->nullable();
            $table->string('status',30);
            $table->integer('total_qty');
            $table->integer('total_weight');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('postcode')->nullable();
            $table->unsignedBigInteger('shipped_by')->nullable();
            $table->datetime('shipped_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('penjualan_id')->references('id_penjualan')->on('penjualans');
            $table->foreign('shipped_by')->references('id')->on('users');
            $table->index('track_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
}
