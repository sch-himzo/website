<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTableDesignLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('log_designs');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('log_designs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('log_id')->unsigned();
            $table->foreign('log_id')->references('id')->on('logs')->onDelete('cascade');
            $table->bigInteger('design_id')->unsigned();
            $table->foreign('design_id')->references('id')->on('designs')->onDelete('cascade');
            $table->string('content');
            $table->timestamps();
        });
    }
}
