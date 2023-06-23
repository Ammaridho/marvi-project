<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantSocialReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_social_references', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->string('name',50);
            $table->string('type',45);
            $table->string('url',255)->nullable();
            $table->string('handler',45)->nullable();
            // index
            $table->index(['merchant_id'],'idx_msr_mid');
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
