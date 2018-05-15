<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 300);
            $table->integer('seller_id')->length(20);
            $table->integer('mini_category_id')->length(20);
            $table->string('tax_class', 100)->nullable();
            $table->string('size', 100)->nullable();
            $table->string('weight', 100)->nullable();
            $table->string('main_material', 100)->nullable();
            $table->string('author', 100)->nullable();
            $table->string('publisher', 100)->nullable();
            $table->text('product_description');
            $table->string('highlight', 100)->nullable();
            $table->text('whats_inthe_box')->nullable();
            $table->text('product_warranty')->nullable();
            $table->string('care_label', 100)->nullable();
            $table->string('youtube_id', 100)->nullable();
            $table->string('product_expiry', 100)->nullable();
            $table->date('product_expiry_date')->nullable();
            $table->string('locally_made_products', 100)->nullable();
            $table->string('publish_status', 100)->nullable();
            $table->date('publish_date')->nullable();
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
        Schema::dropIfExists('products');
    }
}
