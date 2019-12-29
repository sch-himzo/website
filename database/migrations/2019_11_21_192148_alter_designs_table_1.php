<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function foo\func;

class AlterDesignsTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('designs',function(Blueprint $table){
            $table->bigInteger('background_id')->nullable()->unsigned();
            $table->foreign('background_id')->references('id')->on('backgrounds')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('designs', function (Blueprint $table){
            $table->dropForeign('designs_background_id_foreign');
            $table->dropColumn('background_id');
        });
    }
}
