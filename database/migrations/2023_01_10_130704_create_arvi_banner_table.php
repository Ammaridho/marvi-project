<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArviBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arvi_banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->integer('order')->nullable();
            $table->text('url')->nullable();
            $table->datetime('date_start')->nullable();
            $table->datetime('date_end')->nullable();
            $table->string('image_type',10)->nullable();
            $table->string('image_mime',20)->nullable();
            $table->text('image_url')->nullable();
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
