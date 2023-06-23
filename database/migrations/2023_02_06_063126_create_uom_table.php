<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uom_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uom',10);
            $table->string('description',25)->nullable();
            $table->smallInteger('grade')->default(1);
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->datetime('delete_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
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
    }
}
