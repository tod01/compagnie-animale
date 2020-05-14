<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('ads');

        Schema::create('ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('description');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('type_of_post');
            $table->unsignedBigInteger('animal_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('user_position');
        });

        Schema::table('ads', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('ads', function($table) {
            $table->foreign('animal_id')->references('id')->on('animals') ->onDelete('cascade');
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
        Schema::dropIfExists('ads');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
