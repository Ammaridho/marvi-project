<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMerchantExtraAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_extra_attribute_list', function (Blueprint $table) {
            $table->integer('brand_extra_attribute_id')->nullable();
            $table->integer('merchant_extra_attribute_id')->nullable()->change();
            // index
            $table->index(['merchant_product_id','merchant_extra_attribute_id',
            'brand_extra_attribute_id'],'idx_meal_mpmeabeaid');
        });
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->renameColumn('fee', 'retail_price');
        });
        Schema::table('merchant_product_variants', function (Blueprint $table) {
            $table->renameColumn('variant_name', 'name');
            $table->renameColumn('variant_type', 'type');
        });
        Schema::table('merchant_inventories', function (Blueprint $table) {
            $table->integer('merchant_product_variant_id')->nullable()->change();
            $table->integer('total_available')->default(0)->change();
            $table->integer('total_allocate')->default(0)->change();
            $table->integer('total_reserved')->default(0)->change();
            $table->integer('active')->default(0)->change();
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
