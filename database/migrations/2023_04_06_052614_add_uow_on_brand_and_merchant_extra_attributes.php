<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUowOnBrandAndMerchantExtraAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_extra_attributes', function (Blueprint $table) {
            $table->string('uow',10)->default('KG')->nullable();
        });
        Schema::table('brand_extra_attributes', function (Blueprint $table) {
            $table->string('uow',10)->default('KG')->nullable();
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
