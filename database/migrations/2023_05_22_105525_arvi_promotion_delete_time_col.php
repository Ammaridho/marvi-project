<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArviPromotionDeleteTimeCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dateTime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
        });

        Schema::table('promotion_codes', function (Blueprint $table) {
            $table->integer('promotion_id');
            $table->dateTime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
            // index
            $table->index(['promotion_id'],'idx_pc_pid');
        });
        Schema::table('merchant_order_promotion', function (Blueprint $table) {
            $table->dateTime('delete_time')->nullable();
            $table->string('delete_by',100)->nullable();
            $table->renameColumn('promotion_id', 'promotion_code_id');
            // index
            $table->index(['promotion_code_id'],'idx_mop_pcid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
