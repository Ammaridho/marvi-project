<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantDeliveriesMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_delivery_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_delivery_id');
            $table->integer('arvi_delivery_id')->nullable();
            $table->integer('arvi_sub_delivery_id')->nullable();
            $table->string('transporter_id',100)->nullable();
            $table->float('cost_delivery')->default(0);
            $table->string('currency',10)->default('IDR');
            $table->smallInteger('active')->default(1);
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->datetime('delete_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->string('delete_by',100)->nullable();
            // index
            $table->index(['merchant_delivery_id','arvi_delivery_id',
            'arvi_sub_delivery_id'],'idx_mdm_mdadiasdid');
        });
        Schema::table('arvi_sub_deliveries', function (Blueprint $table) {
            $table->smallInteger('active')->default(1);
        });
        Schema::table('arvi_deliveries', function (Blueprint $table) {
            $table->smallInteger('active')->default(1);
        });
        Schema::table('merchant_deliveries', function (Blueprint $table) {
            $table->dropColumn('delivery_method');
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
