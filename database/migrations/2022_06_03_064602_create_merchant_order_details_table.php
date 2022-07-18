<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->integer('merchant_order_id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->integer('product_id');
            $table->integer('variant_id')->nullable();
            $table->string('qty',45)->default(0);
            $table->string('uom',10)->default('PCS')->nullable();
            $table->float('selling_price')->default(0);
            $table->string('currency',5)->nullable()->default('Rp ');
            // index
            $table->index(['merchant_id','merchant_order_id','product_id','variant_id'],'idx_mmod_mopvid');
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
