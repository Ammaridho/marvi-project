<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variant_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->integer('variant_id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('image_type',10)->default('MAIN');
            $table->string('image_mime',20)->nullable();
            $table->string('url',300);
            // index
            $table->index(['merchant_id','variant_id'],'idx_pvi_mvid');
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
