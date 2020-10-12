<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPenjualanShippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->datetime('payment_due')->nullable()->after('status');
            $table->string('payment_status')->nullable()->after('payment_due');
            $table->string('payment_token')->after('payment_status')->nullable();
            $table->string('payment_url')->after('payment_token')->nullable();


            $table->decimal('shipping_cost', 16, 2)->default(0)->nullable()->after('payment_url');
            $table->decimal('grand_total', 16, 2)->default(0)->nullable()->after('shipping_cost');
            $table->text('note')->nullable()->after('grand_total');
            $table->string('customer_first_name')->nullable()->after('note');
            $table->string('customer_last_name')->nullable()->after('customer_first_name');
            $table->string('customer_company')->nullable()->after('customer_last_name');
            $table->string('customer_address1')->nullable()->after('customer_company');
            $table->string('customer_address2')->nullable()->after('customer_address1');
            $table->string('customer_phone')->nullable()->after('customer_address2');
            $table->string('customer_email')->nullable()->after('customer_phone');
            $table->string('customer_city_id')->nullable()->after('customer_email');
            $table->string('customer_province_id')->nullable()->after('customer_city_id');
            $table->integer('customer_postcode')->nullable()->after('customer_province_id');
            $table->string('shipping_courier')->nullable()->after('customer_postcode');
            $table->string('shipping_service_name')->nullable()->after('shipping_courier');
            $table->unsignedBigInteger('approved_by')->nullable()->after('shipping_service_name');
            $table->datetime('approved_at')->nullable()->after('approved_by');
            $table->unsignedBigInteger('cancelled_by')->nullable()->after('approved_at');
            $table->datetime('cancelled_at')->nullable()->after('cancelled_by');
            $table->text('cancellation_note')->nullable()->after('cancelled_at');
            $table->softDeletes()->after('cancellation_note');

            $table->foreign('approved_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cancelled_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
         
            $table->index('payment_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualans', function (Blueprint $table) {
			$table->dropColumn('payment_due');
			$table->dropColumn('payment_status');
			$table->dropColumn('payment_token');
			$table->dropColumn('payment_url');
			$table->dropColumn('shipping_cost');
			$table->dropColumn('grand_total');
			$table->dropColumn('note');
			$table->dropColumn('customer_first_name');
			$table->dropColumn('customer_last_name');
			$table->dropColumn('customer_address1');
			$table->dropColumn('customer_address2');
			$table->dropColumn('customer_phone');
			$table->dropColumn('customer_email');
			$table->dropColumn('customer_city_id');
			$table->dropColumn('customer_province_id');
			$table->dropColumn('customer_postcode');
			$table->dropColumn('shipping_courier');
			$table->dropColumn('shipping_service_name');
			$table->dropColumn('approved_by');
			$table->dropColumn('approved_at');
			$table->dropColumn('cancelled_by');
			$table->dropColumn('cancelled_at');
			$table->dropColumn('cancellation_note');
        });
    }
}
