<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiniCategoryBrand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mini_category_brand', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mini_category_id');
            $table->timestamps();
            
            $table->foreign('mini_category_id')->references('id')
                    ->on('mini_categories')->onDelete('CASCADE')
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
        Schema::dropIfExists('mini_category_brand');
    }
}
