<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCategoriesTableAddicon extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //

        Schema::table('categories', function (Blueprint $table) {
            $table->string('icon', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
