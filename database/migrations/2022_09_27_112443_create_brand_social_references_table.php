<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandSocialReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_social_references', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->string('name',50);
            $table->string('type',45);
            $table->string('url',255)->nullable();
            $table->string('handler',45)->nullable();
            // index
            $table->index(['brand_id'],'idx_bsr_bid');
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
