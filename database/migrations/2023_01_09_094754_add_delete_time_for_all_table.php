<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteTimeForAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('arvi_deliveries', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_menus', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_templates', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_available_days', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('arvi_menus', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_orders', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_order_details', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('order_detail_attributes', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('arvi_payment_methods', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_payments', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_defined_deliveries', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('arvi_payment_providers', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_stripe_sessions', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('product_categories', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('product_category_list', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_social_references', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_hours', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('locations', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_fee_list', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_extra_attribute_list', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_deliveries', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('order_fee_list', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_order_product_attribute_list', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('merchant_order_product_extra_attribute_list', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('brand_kvs', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('brand_menu_attributes', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('location_merchants', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('brand_social_references', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('brand_product_variants', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('brand_products', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('brand_extra_attributes', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('brand_images', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('brand_categories', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('brand_category_list', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('brand_fee_list', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('brand_extra_attribute_list', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('brand_product_attributes', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('user_companies', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('user_brands', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('user_address', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('squads', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });
        Schema::table('settlements', function (Blueprint $table) {
            $table->datetime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
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
