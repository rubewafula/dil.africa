<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiniCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mini_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_category_id', 20);
            $table->string('name', 100);
            $table->string('slug', 50)->nullable();
            $table->string('logo', 100)->nullable();
            $table->text('description')->nullable();
            $table->integer('status', 20)->default(1);
            $table->string('cover_photo', 200)->nullable();
            $table->timestamps();
            
            $table->foreign('sub_category_id')->references('id')
                    ->on('sub_categories')->onDelete('RESTRICT')
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
        Schema::dropIfExists('mini_categories');
    }
}
