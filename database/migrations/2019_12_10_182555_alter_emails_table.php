<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emails',function(Blueprint $table){
            $table->datetime('sent_at')->nullable();
            $table->boolean('send')->default(0);
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
            $table->dropColumn('sent_at');
            $table->dropColumn('send');
        });
    }
}
