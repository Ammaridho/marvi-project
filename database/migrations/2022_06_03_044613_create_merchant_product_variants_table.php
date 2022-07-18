<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id'); 
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('variant_type',45);
            $table->string('variant_name',45);
            $table->string('sku',100);
            $table->integer('merchant_product_id');
            $table->float('retail_price')->default(0);
            $table->string('currency_price',5)->default('Rp ')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->smallInteger('active')->default(1);
            $table->float('width')->default(0);
            $table->float('height')->default(0);
            $table->float('length')->default(0);
            $table->double('weight')->default(0);
            $table->string('uom',10)->default('PCS');
            $table->string('uow',10)->default('KG');
            // Index
            $table->index(['merchant_id','merchant_product_id'],'idx_mpv_mmpid');
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
