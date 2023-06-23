<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantFeeListAndExtraAttributeListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_fee_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_product_id');
            $table->integer('fee_id');
            $table->string('label',100)->nullable();
            $table->integer('priority')->nullable();
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->string('create_by',45)->nullable();
            $table->string('update_by',45)->nullable();
            $table->smallInteger('active')->default(1);
            // index
            $table->index(['merchant_product_id','fee_id'],'idx_mfl_mpfid');
        });

        Schema::create('merchant_extra_attribute_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_product_id');
            $table->integer('merchant_extra_attribute_id');
            $table->string('label',100)->nullable();
            $table->integer('priority')->nullable();
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->string('create_by',45)->nullable();
            $table->string('update_by',45)->nullable();
            $table->smallInteger('active')->default(1);
            // index
            $table->index(['merchant_product_id','merchant_extra_attribute_id'],'idx_meal_mpmeaid');
        });

        Schema::table('product_attributes', function (Blueprint $table) {
            $table->smallinteger('bundle_to_menu')->default(0);
            $table->text('description')->nullable();
            $table->string('image_url',300)->nullable();
        });

        Schema::table('merchant_product_variants', function (Blueprint $table) {
            $table->smallinteger('bundle_to_menu')->default(0);
            $table->text('description')->nullable();
            $table->string('image_url',300)->nullable();
        });

        Schema::table('merchant_products', function (Blueprint $table) {
            $table->integer('discount_price')->nullable();
            $table->text('available_days')->nullable();
        });

        Schema::table('product_category_list', function (Blueprint $table) {
            $table->dropColumn('merchant_id');
            $table->integer('product_category_id')->nullable()->change();
            $table->integer('brand_category_id')->nullable();
            $table->dropColumn('priority');
            // index
            $table->index(['merchant_product_id','product_category_id','brand_category_id'],'idx_pcl_mppcbcid');
        });
        Schema::table('product_category_list', function (Blueprint $table) {
            $table->integer('priority')->nullable();
        });

        Schema::table('merchant_product_variants', function (Blueprint $table) {
            $table->dropColumn('merchant_id');
            $table->string('variant_type',45)->nullable()->change();
            $table->string('sku',45)->nullable()->change();
        });
        
        Schema::rename('extra_attributes', 'merchant_extra_attributes');
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
