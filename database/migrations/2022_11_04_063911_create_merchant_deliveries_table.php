<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // merchant delivery
        Schema::create('merchant_deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->text('delivery_method');
            $table->integer('range_area')->nullable();
            $table->smallinteger('support_delivery_min_order_amount')->default(0);
            $table->float('delivery_min_order_amount')->nullable();
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->string('create_by',45)->nullable();
            $table->string('update_by',45)->nullable();
            // index
            $table->index(['merchant_id'],'idx_mds_mid');
        });

        // merchant pickup
        Schema::table('merchants', function (Blueprint $table) {
            $table->smallinteger('support_delivery')->default(0);
            $table->smallinteger('support_pickup')->default(0);
            $table->smallinteger('support_pickup_min_order_amount')->default(0);
            $table->float('pickup_min_order_amount')->nullable();
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
