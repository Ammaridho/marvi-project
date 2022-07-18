<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('image_type',10)->default('MAIN');
            $table->string('image_mime',100)->nullable();
            $table->string('url',300);
            $table->integer('merchant_product_id');
            $table->smallInteger('active')->default(1);
            // index
            $table->index(['merchant_id'],'idx_pi_mid');
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
