<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArviArsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arvi_ars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->text('file_name');
            $table->text('ar_url');
            $table->string('code',45)->unique();
            $table->string('image_type',10)->nullable();
            $table->string('image_mime',20)->nullable();
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->datetime('delete_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->string('delete_by',100)->nullable();
            $table->smallInteger('active')->default(1);
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
