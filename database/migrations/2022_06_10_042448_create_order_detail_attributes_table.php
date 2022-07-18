<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('order_detail_id');
            $table->integer('product_attribute_id');
            $table->dateTime('create_time');
            $table->integer('qty');
            $table->float('fee')->default(0);
            $table->string('currency',5)->nullable()->default('Rp ');
            // index
            $table->index(['order_id','order_detail_id','product_attribute_id'],'idx_opa_oodpaid');
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
