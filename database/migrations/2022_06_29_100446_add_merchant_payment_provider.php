<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMerchantPaymentProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('merchant_payments','payment_provider_id')) {
            Schema::table('merchant_payments', function (Blueprint $table) {
                $table->integer('payment_provider_id')->default(0)->nullable();
                $table->float('fee')->default(0)->nullable();
                $table->smallInteger('is_fee_percentage')->default(0)->nullable();
                $table->string('currency',5)->default('IDR')->nullable();
            });
        }
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
