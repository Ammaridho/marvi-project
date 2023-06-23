<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArviPromotions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('type_code')->default(0)->comment(
                '0 - General, 1 - Unique'
            );
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->date('date_start');
            $table->date('date_end');
            $table->smallInteger('promo_type')->default(0)->comment(
                '0 - Discount, 1 - Fixed Value of Total Price'
            );
            $table->float('promo_value')->default(0);
            $table->string('currency',5)->default('IDR')->nullable();
            $table->string('tz',45)->default('Asia/Jakarta')->nullable();
            $table->smallInteger('validation_type')->default(0)->comment(
                '0 - Non Unique Customer, 1 - Unique Customer'
            );
        });

        Schema::create('promotion_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->string('code',50);
            $table->smallInteger('is_active')->default(1);
        });

        Schema::create('merchant_order_promotion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_order_id');
            $table->integer('promotion_id');
            $table->string('code', 50);
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
