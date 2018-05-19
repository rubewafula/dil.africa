<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotDeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_deals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->length(20);
            $table->double('discount', 10,2);
            $table->datetime('expires_on');
            $table->double('offer_price', 10,2);
            $table->double('price_before', 10,2);
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
        //
    }
}
