<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromotionBanners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_banners', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('promotion_section_id')->length(20);
            $table->date('active_from');
            $table->date('active_to');
            $table->string('url', 200);
            $table->string('banner', 100);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotion_banners');
    }
}