<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('product_id',100);
            $table->string('name',255)->nullable();
            $table->string('description',255)->nullable();
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

            // Index
            $table->index(['merchant_id','product_id'],'idx_mp_mpid');
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
