<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();          
            $table->integer('arvi_menu_id');
            $table->smallInteger('ordering')->default(0);
            // index
            $table->index(['merchant_id','arvi_menu_id'],'idx_mm_mamid');
        });
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
