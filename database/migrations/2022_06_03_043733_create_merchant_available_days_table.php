<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantAvailableDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_available_days', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->smallInteger('day_of_week')->default(0)->nullable();
            $table->string('hours_csv',45)->nullable();
            // index
            $table->index(['merchant_id'],'idx_mad_mid');
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
