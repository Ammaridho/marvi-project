<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->integer('merchant_product_id');
            $table->integer('merchant_product_variant_id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();            
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->integer('total_available')->default(0);
            $table->integer('total_allocate')->default(0);
            $table->integer('total_reserved')->default(0);
            // index
            $table->index(['merchant_id','merchant_product_id','merchant_product_variant_id'],'idx_mi_mmpmpvid');
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
