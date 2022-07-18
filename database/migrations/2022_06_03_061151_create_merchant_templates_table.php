<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();            
            $table->string('template_key',100)->nullable();
            $table->integer('template_value_int')->nullable();
            $table->string('template_value_string',255)->nullable();
            $table->text('template_value_text')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable(); 
            // index
            $table->index(['merchant_id'],'idx_mt_mid');
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
