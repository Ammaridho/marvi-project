<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributeForPosterQr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arvi_qrs', function (Blueprint $table) {
            $table->text('image_poster')->nullable();
            $table->text('image_logo_poster')->nullable();
            $table->text('image_background_poster')->nullable();
            $table->text('title_poster')->nullable();
            $table->string('title_color_poster',20)->nullable();
            $table->text('sub_title_poster')->nullable();
            $table->string('sub_title_color_poster',20)->nullable();
            $table->text('description_poster')->nullable();
            $table->string('description_color_poster',20)->nullable();
            $table->text('helper_poster')->nullable();
            $table->string('helper_color_poster',20)->nullable();
            $table->smallInteger('show_store_loc_poster')->default(1)->nullable();
            $table->smallInteger('show_social_icons_poster')->default(1)->nullable();
            $table->string('global_text_color_poster',20)->nullable();
            $table->string('backgrount_color_poster',20)->nullable();
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
