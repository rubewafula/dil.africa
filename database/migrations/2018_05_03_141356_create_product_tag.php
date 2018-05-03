<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id', 20);
            $table->integer('tag_id', 20);
            $table->timestamps();
            
            $table->foreign('product_id')->references('id')
                    ->on('products')->onDelete('RESTRICT')
                    ->onUpdate('CASCADE');
            
            $table->foreign('tag_id')->references('id')
                    ->on('tags')->onDelete('RESTRICT')
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
        Schema::dropIfExists('product_tag');
    }
}
