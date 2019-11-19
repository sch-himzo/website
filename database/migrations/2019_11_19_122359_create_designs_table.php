<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('design_group_id')->unsigned();
            $table->foreign('design_group_id')->references('id')->on('design_groups')->onDelete('cascade');
            $table->bigInteger('original_order_id')->unsigned()->nullable();
            $table->foreign('original_order_id')->references('id')->on('orders')->onDelete('set null');
            $table->string('image');
            $table->string('name');
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
        Schema::dropIfExists('designs');
    }
}
