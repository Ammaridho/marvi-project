<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArviPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arvi_payment_methods', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name',100);
            $table->dateTime('create_time');
            $table->dateTime('update_time')->nullable();
            $table->string('code',15)->unique();
            $table->float('fee')->default(0);
            $table->smallInteger('is_fee_precentage')->default(0);
            $table->string('currency',5)->default('Rp ');
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
