<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrelloCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trello_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trello_id');
            $table->string('name');
            $table->text('desc');
            $table->string('idLabels');
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
        Schema::dropIfExists('trello_cards');
    }
}
