<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderPredefinedDelivery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('merchant_orders','defined_delivery_id')) {
            Schema::table('merchant_orders', function (Blueprint $table) {
                $table->integer('defined_delivery_id')->nullable();
                $table->string('address',255)->nullable();
                $table->float('loc_lan')->nullable();
                $table->float('loc_lat')->nullable();
                $table->string('postal_code',10)->nullable();
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
