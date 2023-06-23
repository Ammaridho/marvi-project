<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('create_by',45)->nullable();
            $table->timestamp('create_time')->nullable();
            $table->string('update_by',45)->nullable();
            $table->timestamp('update_time')->nullable();
            $table->enum('deliver_method',['pickup','delivery'])->nullable();
            $table->text('avaibility_store')->nullable();
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
