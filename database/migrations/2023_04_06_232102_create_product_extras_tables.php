<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductExtrasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('brand_product_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_product_id');
            $table->string('key_name',100);
            $table->unique(['brand_product_id','key_name']);
            $table->text('value_string');
            // index
            $table->index(['brand_product_id'],'idx_bpe_bpid');
        });

        Schema::create('merchant_product_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_product_id');
            $table->string('key_name',100);
            $table->unique(['merchant_product_id','key_name']);
            $table->text('value_string');
            // index
            $table->index(['merchant_product_id'],'idx_mpe_mpid');
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
