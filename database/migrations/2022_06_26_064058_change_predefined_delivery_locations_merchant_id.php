<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//SHOULD-NOT-CREATED
class ChangePredefinedDeliveryLocationsMerchantId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::table('predefined_delivery_locations', function (Blueprint $table) {
        //    $table->renameColumn('merchants_id', 'merchant_id');
        //});
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
