<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSkuForVariantAttributeExtraAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_product_variants', function (Blueprint $table) {
            $table->string('sku',100)->nullable();
            $table->smallInteger('mandatory')->default(0);
        });
        Schema::table('brand_product_attributes', function (Blueprint $table) {
            $table->string('sku',100)->nullable();
            $table->smallInteger('mandatory')->default(0);
        });
        Schema::table('brand_extra_attributes', function (Blueprint $table) {
            $table->string('sku',100)->nullable();
        });
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->string('sku',100)->nullable();
            $table->smallInteger('mandatory')->default(0);
        });
        Schema::table('merchant_extra_attributes', function (Blueprint $table) {
            $table->string('sku',100)->nullable();
        });
        Schema::table('merchant_product_variants', function (Blueprint $table) {
            $table->smallInteger('mandatory')->default(0);
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
