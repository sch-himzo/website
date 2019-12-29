<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrdersTable5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders',function(Blueprint $table){
            $table->bigInteger('design_id')->unsigned()->nullable();
            $table->foreign('design_id')->references('id')->on('design_groups')->onDelete('set null');
            $table->boolean('existing_design')->default(false);
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
            $table->dropColumn('existing_design');
            $table->dropForeign('orders_design_id_foreign');
            $table->dropColumn('design_id');
        });
    }
}
