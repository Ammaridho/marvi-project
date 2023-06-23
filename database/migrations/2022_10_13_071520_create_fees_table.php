<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->string('name',50);
            $table->string('type_fee',45);
            $table->float('value_fee');
            $table->string('type_value',20);
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->smallinteger('active')->default(1);
            // index
            $table->index(['brand_id'],'idx_f_bid');
        });

        Schema::table('merchants', function (Blueprint $table) {
            $table->string('currency',5)->default('IDR');
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->smallinteger('active')->default(1);
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
