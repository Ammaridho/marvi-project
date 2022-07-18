<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArviDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arvi_deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('code',45)->unique();
            $table->smallInteger('external')->default(0);
            $table->dateTime('create_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->dateTime('update_time')->nullable();
            $table->string('update_by',100)->nullable();
            $table->float('cost_delivery')->default(0);
            $table->string('currency')->default('Rp ');
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
