<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBrandIdToTableMerchantProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_products', function (Blueprint $table) {
            $table->dropColumn('brand_product_id');
            $table->integer('brand_id')->nullable();
            // index
            $table->index(['brand_id'],'idx_mp_bid');
        });
        Schema::table('merchant_extra_attributes', function (Blueprint $table) {
            $table->integer('brand_id')->nullable();
            // index
            $table->index(['brand_id'],'idx_mea_bid');
        });
        Schema::table('merchant_product_variants', function (Blueprint $table) {
            $table->integer('brand_id')->nullable();
            $table->integer('merchant_id')->nullable();
            // index
            $table->index(['brand_id','merchant_id'],'idx_mpv_bmid');
        });
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->integer('brand_id')->nullable();
            $table->integer('merchant_id')->nullable();
            // index
            $table->index(['brand_id','merchant_id'],'idx_pa_bmid');
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
