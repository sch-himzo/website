<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDesignsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('designs', function(Blueprint $table){
            $table->integer('color_count')->nullable();
            $table->integer('stitch_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('designs', function(Blueprint $table){
            $table->dropColumn('stitch_count');
            $table->dropColumn('color_count');
        });
    }
}
