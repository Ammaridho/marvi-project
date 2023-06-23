<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArviQrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arvi_qrs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->integer('merchant_id');
            $table->smallInteger('qr_type');
            $table->text('qr_url');
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            $table->datetime('delete_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->string('delete_by',100)->nullable();
            $table->smallInteger('active')->default(1);
            // index
            $table->index(['merchant_id'],'idx_aq_mid');
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
