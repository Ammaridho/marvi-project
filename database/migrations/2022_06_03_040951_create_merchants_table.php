<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('code',45)->unique();
            $table->string('name',50);
            $table->smallInteger('loc_aware')->default(0);
            $table->double('loc_lon')->default(0);
            $table->double('loc_lat')->default(0);
            $table->string('description',255)->nullable();
            $table->string('address',255)->nullable();
            $table->string('city',100)->nullable();
            $table->string('country',45)->default('ID');
            $table->string('postal_code',15)->nullable();
            $table->string('location_label',50)->nullable();
            $table->integer('loc_aware_tolerance')->default(1);
            $table->string('loc_aware_uom',10)->default('KM')->nullable();
            $table->integer('company_id');
            $table->string('default_template',45)->nullable();
            $table->string('loc_tz',45)->default('Asia/Jakarta')->nullable();
            $table->string('create_by',100)->nullable();
            $table->string('update_by',100)->nullable();
            $table->integer('order_days_ahead')->default(3);
            $table->smallInteger('active')->default(1);      
            // index
            $table->index(['company_id'],'idx_m_cid');
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
