<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('squad_id');
            $table->integer('merchant_order_id');
            $table->smallinteger('progress_status')->default(1);
            $table->smallinteger('settlement_status')->default(1);
            $table->float('remaining')->default(0);
            $table->datetime('create_time');
            // index
            $table->index(['squad_id','merchant_order_id'],'idx_s_smoid');
        });
        Schema::table('squads', function (Blueprint $table) {
            $table->float('balance')->default(0);
            $table->float('remaining')->default(0);
            $table->integer('total_order')->default(0);
            $table->smallinteger('settlement_status')->default(0);
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
