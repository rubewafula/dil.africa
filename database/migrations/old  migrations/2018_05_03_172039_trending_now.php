<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrendingNow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trending_now', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->timestamps();
            
            $table->foreign('brand_id')->references('id')
                    ->on('brands')->onDelete('RESTRICT')
                    ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trending_now');
    }
}
