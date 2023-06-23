<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArviSubDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arvi_sub_deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('arvi_delivery_id');
            $table->string('name',45);
            $table->string('image_type',10)->nullable();
            $table->string('image_mime',20)->nullable();
            $table->text('image_url')->nullable();
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->datetime('delete_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->string('delete_by',100)->nullable();
            // index
            $table->index(['arvi_delivery_id'],'idx_asd_adid');
        });
        Schema::table('arvi_deliveries', function (Blueprint $table) {
            $table->string('image_type',10)->nullable();
            $table->string('image_mime',20)->nullable();
            $table->text('image_url')->nullable();
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
