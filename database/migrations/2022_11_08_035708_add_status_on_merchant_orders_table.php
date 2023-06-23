<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusOnMerchantOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_orders', function (Blueprint $table) {
            $table->dropColumn('fulfilment_status');
            $table->dropColumn('order_status');
        });
        Schema::table('merchant_orders', function (Blueprint $table) {
            $table->smallinteger('fulfilment_status')->default(1);
            $table->smallinteger('order_status')->default(1);
            $table->datetime('day_deliver')->change();
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
