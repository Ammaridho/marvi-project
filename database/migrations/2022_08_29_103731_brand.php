<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Brand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('code',45)->unique();
            $table->string('name',50);
            $table->string('description',255)->nullable();
            $table->string('country',45)->default('ID');
            $table->string('postal_code',15)->nullable();
            $table->integer('company_id');
            $table->string('default_template',45)->nullable();
            $table->string('loc_tz',45)->default('Asia/Jakarta')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->smallInteger('active')->default(1);

            $table->string('image_url',100)->nullable();
            $table->string('phone_number',25)->nullable();
            $table->string('cover_img',300)->nullable();
            $table->string('banner_img',300)->nullable();

            // index
            $table->index(['company_id'],'idx_b_cid');
        });

        Schema::table('merchants', function (Blueprint $table) {
            $table->integer('brand_id')->nullable();
            $table->float('avg_rating')->default(0);

            $table->index(['brand_id'],'idx_m_bid');
        });

        /* --- end brand -- */

        Schema::create('brand_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('product_id',100);
            $table->string('name',255)->nullable();
            $table->string('sku',100);
            $table->float('retail_price')->default(0);
            $table->string('currency',5)->default('Rp ');
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->smallInteger('active')->default(1);
            $table->string('uom',10)->default('PCS');
            $table->double('weight')->nullable()->default(0);
            $table->float('length')->nullable()->default(0);
            $table->float('width')->nullable()->default(0);
            $table->float('height')->nullable()->default(0);
            $table->string('uow',10)->default('KG')->nullable();

            $table->integer('preparation_time')->nullable();
            $table->integer('min_order')->nullable();
            $table->integer('max_order')->nullable();
            $table->float('avg_rating')->nullable();
            $table->text('description')->nullable();
            $table->string('promo_msg',255)->nullable();

            // Index
            $table->index(['brand_id','product_id'],'idx_bp_bpid');
        });

        Schema::table('merchant_products', function (Blueprint $table) {
            $table->integer('brand_product_id')->nullable();
            $table->index(['brand_product_id'],'idx_mp_bpid');
        });

        /* --- end brand products -- */

        Schema::create('brand_menu_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->string('type',100)
                ->default('ADDON');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->string('name',100);
            $table->string('uom',5)->nullable();
            $table->float('fee')->default(0);
            $table->string('currency',5)->nullable()->default('Rp ');
            $table->smallInteger('active')->default(1);
            // index
            $table->index(['brand_id'],'idx_bma_bmbid');
        });

        Schema::create('brand_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('image_type',10)->default('MAIN');
            $table->string('image_mime',100)->nullable();
            $table->string('url',300);
            $table->integer('brand_product_id')->nullable();
            $table->smallInteger('active')->default(1);
            // index
            $table->index(['brand_id'],'idx_bi_bid');
        });

        Schema::create('brand_kvs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->string('key_name',100);
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->string('value_string',255)->nullable();
            $table->text('value_txt')->nullable();
            $table->integer('value_int')->default(0)->nullable();
            // index
            $table->unique(['brand_id','key_name'],'idx_bkv_bid');
        });

        /* --- end brand related -- */



        Schema::table('merchant_orders', function (Blueprint $table) {
            $table->integer('brand_id')->nullable();
            $table->index(['brand_id'],'idx_mo_bid');
        });

        Schema::table('merchant_order_details', function (Blueprint $table) {
            $table->text('extra_payload')->nullable();
        });

        /* --- end merchant order update -- */


        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('code',45)->unique();
            $table->string('name',50);
            $table->smallInteger('loc_aware')->default(0);
            $table->double('loc_lon')->default(0);
            $table->double('loc_lat')->default(0);
            $table->string('description',255)->nullable();
            $table->string('address',255)->nullable();
            $table->string('city',100)->nullable();
            $table->string('country',45)->default('ID');
            $table->string('postal_code',15)->nullable();
            $table->integer('loc_aware_tolerance')->default(1);
            $table->string('loc_aware_uom',10)->default('KM')->nullable();
            $table->integer('company_id');
            $table->string('loc_tz',45)->default('Asia/Jakarta')->nullable();
            $table->string('location_type',45)->default('Building')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();

            $table->smallInteger('active')->default(1);
            // index
            $table->index(['company_id'],'idx_loc_cid');
        });

        Schema::create('location_merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id');
            $table->integer('merchant_id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            // index
            $table->unique(['location_id','merchant_id'],'idx_lm_locid');
        });

        /* --- end locations -- */




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
