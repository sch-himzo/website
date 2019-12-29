<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrdersTable11 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function(Blueprint $table){
            $table->dropForeign('orders_user_id_foreign');
            $table->dropForeign('orders_approved_by_foreign');
            $table->dropForeign('orders_design_id_foreign');
            $table->dropForeign('orders_temp_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('internal');
            $table->dropColumn('image');
            $table->dropColumn('approved_by');
            $table->dropColumn('trello_card');
            $table->dropColumn('temp_user_id');
            $table->bigInteger('order_group_id')->unsigned();
            $table->foreign('order_group_id')->references('id')->on('order_groups')->onDelete('cascade');
            $table->dropColumn('public_albums');
            $table->bigInteger('design_group_id')->unsigned()->nullable();
            $table->foreign('design_group_id')->references('id')->on('design_groups')->onDelete('set null');
            $table->dropColumn('design_id');
            $table->dropColumn('archived');
            $table->dropColumn('joint');
            $table->dropColumn('help');
            $table->integer('status')->default(0)->charset(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function(Blueprint $table){
            $table->string('status')->nullable()->change();
            $table->boolean('help');
            $table->boolean('joint');
            $table->boolean('archived');
            $table->bigInteger('design_id')->unsigned()->nullable();
            $table->foreign('design_id')->references('id')->on('design_groups')->onDelete('set null');
            $table->dropForeign('orders_design_group_id_foreign');
            $table->dropColumn('design_group_id');
            $table->boolean('public_albums');
            $table->dropForeign('orders_order_group_id_foreign');
            $table->dropColumn('order_group_id');
            $table->bigInteger('temp_user_id')->unsigned()->nullable();
            $table->foreign('temp_user_id')->references('id')->on('temp_users')->onDelete('set null');
            $table->string('trello_card');
            $table->bigInteger('approved_by')->unsigned()->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->string('image')->nullable();
            $table->boolean('internal');
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
}
