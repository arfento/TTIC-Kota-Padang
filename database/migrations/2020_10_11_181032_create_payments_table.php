<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id_payment');
            $table->unsignedBigInteger('penjualan_id');
            $table->string('number', 50)->unique();
            $table->decimal('amount', 16, 2)->default(0);
            $table->string('method',30);
            $table->string('token')->nullable();
            $table->json('payloads')->nullable();
            $table->string('payment_type', 50)->nullable();
            $table->string('va_number', 50)->nullable();
            $table->string('vendor_name',50)->nullable();
            $table->string('biller_code',50)->nullable();
            $table->string('bill_key',50)->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('penjualan_id')->references('id_penjualan')->on('penjualans');
            $table->index('number');
            $table->index('method');
            $table->index('token');
            $table->index('payment_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
