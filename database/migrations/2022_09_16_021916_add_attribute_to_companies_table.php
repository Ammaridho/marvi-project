<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributeToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('email',255)->nullable();
            $table->string('phone_number',25)->nullable();
            $table->string('street_address',255)->nullable();
            $table->string('city',100)->nullable();
            $table->string('postal_code',15)->nullable();
            $table->string('building_suite',100)->nullable();
            $table->string('state',100)->nullable();
            $table->string('country',45)->nullable();
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
