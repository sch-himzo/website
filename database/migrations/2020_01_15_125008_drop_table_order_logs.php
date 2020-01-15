<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTableOrderLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('log_orders');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('log_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('log_id')->unsigned();
            $table->foreign('log_id')->references('id')->on('logs')->onDelete('cascade');
            $table->bigInteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('content');
            $table->timestamps();
        });
    }
}
