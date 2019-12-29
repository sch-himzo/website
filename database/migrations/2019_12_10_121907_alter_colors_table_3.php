<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColorsTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('colors', function(Blueprint $table){
            $table->dropColumn('green');
            $table->dropColumn('blue');
            $table->string('red')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('colors', function (Blueprint $table){
            $table->integer('red')->nullable()->change();
            $table->integer('green')->nullable();
            $table->integer('blue')->nullable();
        });
    }
}
