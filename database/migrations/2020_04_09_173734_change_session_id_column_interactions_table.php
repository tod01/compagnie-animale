<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSessionIdColumnInteractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE interactions CHANGE sessionId sessionId VARCHAR(255)');
    }

    public function down()
    {
        DB::statement('ALTER TABLE interactions CHANGE sessionId sessionId VARCHAR(255)');
    }
}
