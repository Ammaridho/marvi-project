<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->string('name',100)->nullable();
            $table->string('hours_type',45);
            $table->timestamp('date')->nullable();
            $table->timestamp('hours_from')->nullable();
            $table->timestamp('hours_to')->nullable();
            $table->enum('condition',['open','close']);
            $table->enum('day',['sunday', 'monday', 'tuesday', 'wednesday', 'thrusday', 'friday', 'saturday'])->nullable();
            // index
            $table->index(['merchant_id'],'idx_mh_mid');
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
