<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->longText('description');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('type_of_post');
            $table->unsignedBigInteger('animal_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('user_position');
            $table->integer('type_of_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
