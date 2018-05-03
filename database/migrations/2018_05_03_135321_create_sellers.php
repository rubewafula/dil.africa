<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellers extends Migration
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
            $table->string('name', 100);
            $table->string('username', 100);
            $table->string('logo', 100)->nullable();
            $table->text('description');
            $table->string('opening_hours', 50)->nullable();
            $table->string('closing_hours', 50)->nullable();
            $table->enum('status', ['ACTIVE', 'CLOSED', 'SUSPENDED']);
            $table->integer('country_id', 20);
            $table->integer('city_id', 20);
            $table->integer('area_id', 20);
            $table->string('physical_location', 100);
            $table->string('email_address', 100);
            $table->string('telephone', 100);
            $table->string('other_telephone', 100)->nullable();
            $table->string('contact_person', 100);
            $table->string('contact_telephone', 100);
            $table->string('contact_email_address', 100);
            $table->integer('warehouse_id', 20)->nullable();
            $table->string('bank_name', 100);
            $table->string('account_name', 100);
            $table->string('account_number', 100);
            $table->string('swift_code', 100)->nullable();
            $table->string('bank_code', 100)->nullable();
            $table->timestamps();
            
            $table->foreign('country_id')->references('id')
                    ->on('countries')->onDelete('RESTRICT')
                    ->onUpdate('CASCADE');
            
            $table->foreign('city_id')->references('id')
                    ->on('cities')->onDelete('RESTRICT')
                    ->onUpdate('CASCADE');
            
            $table->foreign('area_id')->references('id')
                    ->on('areas')->onDelete('RESTRICT')
                    ->onUpdate('CASCADE');
            
            $table->foreign('warehouse_id')->references('id')
                    ->on('warehouses')->onDelete('RESTRICT')
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
        Schema::dropIfExists('sellers');
    }
}
