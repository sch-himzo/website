<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTrelloCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trello_cards', function(Blueprint $table){
            $table->bigInteger('list_id')->unsigned()->nullable();
            $table->foreign('list_id')->references('id')->on('trello_lists')->onDelete('set null');
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trello_cards', function(Blueprint $table){
            $table->dropColumn('status');
            $table->dropForeign('trello_cards_list_id_foreign');
            $table->dropColumn('list_id');
        });
    }
}
