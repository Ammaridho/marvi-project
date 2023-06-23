<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSquadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('squads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id');
            $table->string('name',50);
            $table->string('phone_number',25)->nullable();
            $table->string('password',255);
            $table->datetime('last_login')->nullable();
            $table->datetime('last_taking_order')->nullable();
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->smallInteger('active')->default(1);
            // index
            $table->index(['location_id'],'idx_s_lid');
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
