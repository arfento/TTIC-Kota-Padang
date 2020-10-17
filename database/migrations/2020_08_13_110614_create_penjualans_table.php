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
            $table->string('nomor_faktur', 50)->unique();
            $table->date('tanggal');
            $table->unsignedBigInteger('total');
            $table->unsignedBigInteger('user_id');
            $table->string('status',30)->nullable();
            $table->datetime('payment_due')->nullable();
            $table->string('payment_status', 30)->nullable();
            $table->string('payment_token')->nullable();
            $table->string('payment_url')->nullable();


            $table->decimal('shipping_cost', 16, 2)->default(0)->nullable();
            $table->decimal('grand_total', 16, 2)->default(0)->nullable();
            $table->text('note')->nullable();
            $table->string('customer_first_name', 50)->nullable();
            $table->string('customer_last_name', 50)->nullable();
            $table->string('customer_company', 50)->nullable();
            $table->string('customer_address1')->nullable();
            $table->string('customer_address2')->nullable();
            $table->string('customer_phone', 15)->nullable();
            $table->string('customer_email', 100)->nullable();
            $table->integer('customer_city_id')->nullable();
            $table->integer('customer_province_id')->nullable();
            $table->integer('customer_postcode')->nullable();
            $table->string('shipping_courier',20)->nullable();
            $table->string('shipping_service_name',30)->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->datetime('cancelled_at')->nullable();
            $table->text('cancellation_note')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('approved_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cancelled_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
         
            $table->index('payment_token');



        });

        Schema::table('penjualans', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('approved_by')->references('id')->on('users');
            // $table->foreign('cancelled_by')->references('id')->on('users');
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
