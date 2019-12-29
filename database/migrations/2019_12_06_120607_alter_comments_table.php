<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function(Blueprint $table){
            $table->dropForeign('comments_order_id_foreign');
            $table->dropColumn('order_id');
            $table->bigInteger('order_group_id')->unsigned();
            $table->foreign('order_group_id')->references('id')->on('order_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table){
            $table->dropForeign('comments_order_group_id_foreign');
            $table->dropColumn('order_group_id');
            $table->bigInteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }
}
