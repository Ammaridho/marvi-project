<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BrandCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->string('category_name',45);
            $table->string('category_type',45);
            $table->smallInteger('is_promo')->default(0);
            $table->integer('discount')->nullable();
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();

            $table->text('deliver_method')->nullable();
            $table->text('availability_store')->nullable();

            // index
            $table->index(['brand_id'],'idx_bc_bid');
        });

        Schema::create('brand_category_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->integer('brand_product_id')->default(0);
            $table->integer('brand_category_id')->default(0);
            $table->integer('priority')->default(1);
            $table->smallInteger('active')->default(1);
            $table->string('label',100)->nullable();

            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();

            // index
            $table->index(['brand_id','brand_category_id'],'idx_bcl_bcmbid');
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
