<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('zone_id');
            $table->integer('city_id');
            $table->string('name', 100);
            $table->timestamps();
            
            $table->foreign('zone_id')->references('id')
                    ->on('zones')->onDelete('RESTRICT')
                    ->onUpdate('CASCADE');
            
            $table->foreign('city_id')->references('id')
                    ->on('cities')->onDelete('RESTRICT')
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
        Schema::dropIfExists('areas');
    }
}
