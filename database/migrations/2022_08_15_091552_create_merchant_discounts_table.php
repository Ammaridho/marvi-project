<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->string('name',100);
            $table->text('message')->nullable();
            $table->enum('type',['precentage','amount']);
            $table->integer('value');
            $table->integer('min_purchase')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('restriction',45)->nullable();
            $table->string('discount_code_type',45)->nullable();
            $table->string('discount_code',100)->nullable();
            // index
            $table->index(['merchant_id'],'idx_md_mid');
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
