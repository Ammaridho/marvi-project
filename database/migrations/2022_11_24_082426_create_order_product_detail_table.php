<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_order_product_attribute_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_order_detail_id');
            $table->integer('product_attribute_id');
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->integer('qty')->default(0);
            $table->float('selling_price')->default(0);
            $table->string('currency',5)->default('IDR');
            $table->text('extra_payload')->nullable();
            $table->string('uom',10)->nullable();
            // index
            $table->index(['merchant_order_detail_id','product_attribute_id'],'idx_mopal_modpaid');
        });
        Schema::create('merchant_order_product_extra_attribute_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_order_detail_id');
            $table->integer('merchant_extra_attribute_id');
            $table->integer('brand_extra_attribute_id');
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->integer('qty')->default(0);
            $table->float('selling_price')->default(0);
            $table->string('currency',5)->default('IDR');
            $table->text('extra_payload')->nullable();
            $table->string('uom',10)->nullable();
            // index
            $table->index(['merchant_order_detail_id','merchant_extra_attribute_id',
            'brand_extra_attribute_id'],'idx_mopeal_modmeabeaid');
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
