<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMerchantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_orders', function (Blueprint $table) {
            $table->integer('merchant_id')->nullable()->change();
            $table->integer('location_id')->nullable();
            // index
            $table->index(['location_id'],'idx_mo_lid');
        });
        Schema::table('merchant_order_details', function (Blueprint $table) {
            $table->text('remarks_product')->nullable();
        });
        Schema::table('merchant_order_product_extra_attribute_list', function (Blueprint $table) {
            $table->integer('merchant_extra_attribute_id')->nullable()->change();
            $table->integer('brand_extra_attribute_id')->nullable()->change();
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
