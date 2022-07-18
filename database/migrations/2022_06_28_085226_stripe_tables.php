<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StripeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_stripe_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->string('session_id',100);
            $table->dateTime('create_time')->nullable();
            $table->dateTime('update_time')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->string('cancel_url',350)->nullable();
            $table->string('success_url',350)->nullable();
            $table->string('mode',15)->nullable();
            $table->string('customer_email',50)->nullable();
            $table->float('amount_subtotal')->default(0)->nullable();
            $table->float('amount_total')->default(0)->nullable();
            $table->string('payment_method_types',350)->nullable();
            $table->string('payment_status',10)->nullable();
            $table->string('payment_link',350)->nullable();
            $table->string('currency',5)->nullable();

            $table->index(['session_id'],'idx_mss_sesid');
            $table->index(['merchant_id'],'idx_mss_mid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
