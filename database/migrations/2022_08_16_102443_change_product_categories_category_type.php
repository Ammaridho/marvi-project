<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProductCategoriesCategoryType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('category_type',45)->default('normal')->change();
            $table->integer('merchant_id')->nullable()->change();
            $table->dropColumn('deliver_method');
        });
        Schema::table('product_categories', function (Blueprint $table) {
            $table->text('deliver_method')->nullable();
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
