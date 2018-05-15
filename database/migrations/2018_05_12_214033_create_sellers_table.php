<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->string('opening_hours')->nullable();
            $table->string('closing_hours')->nullable();
            $table->string('status');
            $table->string('country_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('area_id')->nullable();
            $table->text('physical_location')->nullable();
            $table->string('email_address')->nullable();
            $table->string('telephone')->nullable();
            $table->string('other_telephone')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_telephone')->nullable();
            $table->string('contact_email_address')->nullable();
            $table->string('warehouse_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('bank_code')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sellers');
    }
}
