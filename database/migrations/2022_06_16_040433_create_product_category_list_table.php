<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoryListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_category_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_category_id');
            $table->integer('merchant_product_id');
            // index
            $table->index(['product_category_id','merchant_product_id'],'idx_pcl_pcmpid');
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
