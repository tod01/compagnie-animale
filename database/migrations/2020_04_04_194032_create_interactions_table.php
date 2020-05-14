<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('interactions');

        Schema::create('interactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->enum('eventType', ['SEARCH', 'VIEW', 'LIKE', 'CONTACT', 'FOLLOW']);
            $table->unsignedBigInteger('personId');
            $table->unsignedBigInteger('postId');
            $table->string('sessionId')->default(session()->getId() ?? '');
            $table->float('eventStrength')->default(0);
            $table->string('userRegion');
        });

        Schema::table('interactions', function($table) {
            $table->foreign('personId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('postId')->references('id')->on('ads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interactions', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            Schema::dropIfExists('interactions');
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        });
    }
}
