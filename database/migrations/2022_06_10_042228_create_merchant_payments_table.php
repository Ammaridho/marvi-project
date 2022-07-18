<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->integer('payment_method_id');
            $table->string('account_number',100)->nullable();
            $table->string('account_name',150)->nullable();
            $table->smallInteger('active')->default(0);
            // index
            $table->index(['merchant_id','payment_method_id'],'idx_mp_mpmid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
