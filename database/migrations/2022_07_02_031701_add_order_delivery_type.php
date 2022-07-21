<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderDeliveryType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('merchant_orders','delivery_type')) {
            Schema::table('merchant_orders', function (Blueprint $table) {
                $table->smallInteger('delivery_type')->default(0)->comment(
                    '//0 - DROP_TO_PICKUP
                    //1 - DELIVER_TO_CUST'
                );
            });
        }
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
