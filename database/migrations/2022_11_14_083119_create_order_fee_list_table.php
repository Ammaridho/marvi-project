<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderFeeListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_fee_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_order_id');
            $table->integer('fee_id');
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->string('create_by',45)->nullable();
            $table->string('update_by',45)->nullable();
            // index
            $table->index(['merchant_order_id','fee_id'],'idx_mfl_mofid');
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
