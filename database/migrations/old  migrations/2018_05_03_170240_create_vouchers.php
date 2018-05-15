<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('voucher_code', 100);
            $table->integer('user_id')->length(20)->nullable();
            $table->string('percent_discount', 100)->nullable();
            $table->double('amount', 10, 2)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->date('active_from');
            $table->date('active_to');
            $table->integer('subcategory_id')->length(20);
            $table->string('voucher_type', 100);
            $table->string('voucher_img', 100);
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
        Schema::dropIfExists('vouchers');
    }
}
