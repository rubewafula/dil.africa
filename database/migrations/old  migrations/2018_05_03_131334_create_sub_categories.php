<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('name', 100);
            $table->string('slug', 50)->nullable();
            $table->string('logo', 100)->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(1);
            $table->string('cover_photo', 200)->nullable();
            $table->timestamps();
            
            $table->foreign('category_id')->references('id')
                    ->on('categories')->onDelete('RESTRICT')
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
        Schema::dropIfExists('sub_categories');
    }
}
