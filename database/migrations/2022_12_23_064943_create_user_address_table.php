<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('location_id');
            $table->string('email',45)->nullable();
            $table->string('name',45);
            $table->string('phone_number',25);
            $table->text('address');
            $table->text('notes')->nullable();
            $table->datetime('create_time');
            $table->datetime('update_time')->nullable();
            // index
            $table->index(['user_id','location_id'],'idx_ua_ulid');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->text('address')->nullable();
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
