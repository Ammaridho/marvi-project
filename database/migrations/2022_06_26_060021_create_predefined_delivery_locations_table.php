<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//SHOULD-NOT-CREATED
class CreatePredefinedDeliveryLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::create('predefined_delivery_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->string('address',255);
            $table->double('loc_lan')->nullable();
            $table->double('loc_lat')->nullable();
            $table->string('postal_code',15);
            // index
            $table->index(['merchants_id'],'idx_pdl_mid');
        });
        */
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
