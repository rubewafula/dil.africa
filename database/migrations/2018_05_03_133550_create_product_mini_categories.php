<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductMiniCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_mini_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id', 20);
            $table->integer('mini_category_id', 20);
            $table->timestamps();
            
            $table->foreign('product_id')->references('id')
                    ->on('products')->onDelete('RESTRICT')
                    ->onUpdate('CASCADE');
            
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
        Schema::dropIfExists('product_mini_categories');
    }
}
