<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MerchantDefinedDelivery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_defined_deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->string('name',100);
            $table->string('address',255)->nullable();
            $table->double('loc_lan')->nullable();
            $table->double('loc_lat')->nullable();
            $table->dateTime('create_time')->nullable();
            $table->dateTime('update_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('currency',5)->default('IDR')->nullable();
            $table->string('postal_code',15)->nullable();
            $table->string('remarks',255)->nullable();
            $table->integer('min_hour_utc')->nullable();
            $table->integer('max_hour_utc')->nullable();
            $table->string('local_tz')->nullable();

            // index
            $table->index(['merchant_id'],'idx_mdefd_mid');
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
