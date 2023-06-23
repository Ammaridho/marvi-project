<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BrandProductVariantAndAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_product_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_product_id');
            $table->string('name',50);
            $table->float('retail_price')->default(0);
            $table->string('currency',5)->default('IDR');
            $table->smallinteger('bundle_to_menu')->default(0);
            $table->text('description')->nullable();
            $table->string('image_url',300)->nullable();
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->string('create_by',45)->nullable();
            $table->string('update_by',45)->nullable();
            $table->smallInteger('active')->default(1);
            // index
            $table->index(['brand_product_id'],'idx_bpa_bpid');
        });

        Schema::create('brand_product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_product_id');
            $table->string('name',50);
            $table->float('retail_price')->default(0);
            $table->string('currency',5)->default('IDR');
            $table->smallinteger('bundle_to_menu')->default(0);
            $table->text('description')->nullable();
            $table->string('image_url',300)->nullable();
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->string('create_by',45)->nullable();
            $table->string('update_by',45)->nullable();
            $table->smallInteger('active')->default(1);
            // index
            $table->index(['brand_product_id'],'idx_bpv_bpid');
        });

        Schema::create('brand_fee_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_product_id');
            $table->integer('fee_id');
            $table->string('label',100)->nullable();
            $table->integer('priority')->nullable();
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->string('create_by',45)->nullable();
            $table->string('update_by',45)->nullable();
            $table->smallInteger('active')->default(1);
            // index
            $table->index(['brand_product_id','fee_id'],'idx_bfl_cbpfid');
        });

        Schema::create('brand_extra_attribute_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_product_id');
            $table->integer('brand_extra_attribute_id');
            $table->string('label',100)->nullable();
            $table->integer('priority')->nullable();
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->string('create_by',45)->nullable();
            $table->string('update_by',45)->nullable();
            $table->smallInteger('active')->default(1);
            // index
            $table->index(['brand_product_id','brand_extra_attribute_id'],'idx_bfl_cbpbeaid');
        });

        Schema::table('brand_products', function (Blueprint $table) {
            $table->integer('discount_price')->nullable();
            $table->text('available_days')->nullable();
        });

        Schema::table('brand_category_list', function (Blueprint $table) {
            $table->dropColumn('brand_id');
            // index
            $table->index(['brand_product_id','brand_category_id'],'idx_bcl_bcmbid');
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
