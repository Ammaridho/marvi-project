<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToProductCategoryListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_category_list', function (Blueprint $table) {
            $table->integer('merchant_id');
            $table->string('priority',45);
            $table->timestamp('create_time');
            $table->string('create_by',45)->nullable();
            $table->timestamp('update_time')->nullable();
            $table->string('update_by',45)->nullable();
            $table->smallinteger('active')->default(1);
            // index
            $table->index(['merchant_id'],'idx_pcl_mid');
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
