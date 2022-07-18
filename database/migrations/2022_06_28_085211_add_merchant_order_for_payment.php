<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMerchantOrderForPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('merchant_orders','payment_provider_id')) {
            Schema::table('merchant_orders', function (Blueprint $table) {
                $table->integer('payment_provider_id')->default(0)->nullable();
                $table->string('payment_session_id',255)->nullable();
                $table->integer('payment_method_id')->nullable();
                $table->integer('payment_status')->default(0)->comment(
                    '0 - NEW, 1 - PAID, 2 - EXPIRED, 4 - FAILED'
                );
                $table->string('payment_status_code',45)->nullable();
                $table->string('arvi_session_id',100)->nullable();
                $table->dateTime('payment_expire_utc')->nullable();

                $table->index(['arvi_session_id'],'idx_mo_arssessid');
            });
        }

        Schema::create('arvi_payment_providers', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name',45);
            $table->string('url',255)->nullable();
            $table->dateTime('create_time')->nullable();
            $table->dateTime('update_time')->nullable();
            $table->smallInteger('active')->default(1);
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
