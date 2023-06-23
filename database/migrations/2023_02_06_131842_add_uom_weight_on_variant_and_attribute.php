<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUomWeightOnVariantAndAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_product_variants', function (Blueprint $table) {
            $table->double('weight')->default(0);
            $table->string('uom',10)->default('PCS');
            $table->string('uow',10)->default('KG');
        });
        Schema::table('brand_product_attributes', function (Blueprint $table) {
            $table->double('weight')->default(0);
            $table->string('uom',10)->default('PCS');
            $table->string('uow',10)->default('KG');
        });
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->double('weight')->default(0);
            $table->string('uow',10)->default('KG');
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
