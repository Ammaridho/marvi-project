<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->date('day_deliver');
            $table->string('source_ip',20)->nullable();
            $table->string('name',200);
            $table->string('email',100)->nullable();
            $table->string('mobile_number',30)->nullable();
            $table->integer('delivery_id');
            $table->float('delivery_fee')->default(0);
            $table->string('currency',5)->nullable()->default('Rp ');
            $table->float('total_gross_price')->default(0);
            $table->float('discount')->default(0);
            $table->string('discount_type',15)->nullable();
            $table->integer('merchan_payment_id');
            $table->text('remarks_order')->nullable();
            $table->text('remarks_deliver')->nullable();
            // index
            $table->index(['merchant_id','delivery_id','merchan_payment_id'],'idx_mo_mdmpid');
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
