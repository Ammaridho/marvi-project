<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsPromotions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('promotions','company_id')) {
            Schema::table('promotions', function (Blueprint $table) {
                $table->integer('company_id');
                $table->integer('brand_id')->default(0)->nullable();
                $table->index(['company_id'],'idx_prm_com');
            });
        }
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
