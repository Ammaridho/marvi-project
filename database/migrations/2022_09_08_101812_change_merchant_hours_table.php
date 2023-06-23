<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMerchantHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_hours', function (Blueprint $table) {
            $table->time('hours_from')->nullable()->change();
            $table->time('hours_to')->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->dropColumn('day');
        });
        Schema::table('merchant_hours', function (Blueprint $table) {
            $table->string('day',45)->nullable();
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
