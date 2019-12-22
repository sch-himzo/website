<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEmailsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emails', function(Blueprint $table){
            $table->string('to_name');
            $table->string('from_name');
            // TODO: add type
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emails', function(Blueprint $table){
            $table->dropColumn('to_name');
            $table->dropColumn('from_name');
        });
    }
}
