<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandExtraAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_extra_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->string('type',100);
            $table->string('name',100);
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->string('uom',5)->nullable();
            $table->float('fee')->default(0);
            $table->string('currency',5)->nullable()->default('Rp ');
            $table->smallInteger('active')->default(1);
            // index
            $table->index(['brand_id'],'idx_bea_bid');
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
