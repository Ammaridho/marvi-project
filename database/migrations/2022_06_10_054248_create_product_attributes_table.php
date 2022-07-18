<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_product_id');
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
            $table->index(['merchant_product_id'],'idx_pa_mpid');
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
