<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->string('category_name',45);
            $table->string('category_type',45);
            $table->smallInteger('is_promo')->default(0);
            $table->integer('discount')->nullable();
            // index
            $table->index(['merchant_id'],'idx_pc_mid');
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
