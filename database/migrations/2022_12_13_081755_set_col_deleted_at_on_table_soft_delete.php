<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetColDeletedAtOnTableSoftDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_products', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
        });
        Schema::table('merchant_product_variants', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
        });
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
        });
        Schema::table('merchant_extra_attributes', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
        });
        Schema::table('product_images', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
        });
        Schema::table('fees', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
        });
        Schema::table('merchant_inventories', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
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
