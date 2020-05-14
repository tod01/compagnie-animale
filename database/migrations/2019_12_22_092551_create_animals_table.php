<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('animals');

        Schema::create('animals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer("age");
            $table->integer("number_of_litters");
            $table->integer("identification_number");
            $table->boolean("is_race");
            $table->boolean("is_vaccinated");
            $table->unsignedBigInteger("race_id");
        });

        Schema::table('animals', function($table) {
            $table->foreign('race_id')->references('id')->on('races')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('animals');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
