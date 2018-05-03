<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsoredProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsored_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('promotion_section_id', 20);
            $table->integer('product_id', 20)->nullable();
            $table->datetime('date_from');
            $table->datetime('date_to');
            $table->timestamps();
            
            $table->foreign('promotion_section_id')->references('id')
                    ->on('promotion_sections')->onDelete('SET NULL')
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
        Schema::dropIfExists('sponsored_products');
    }
}
