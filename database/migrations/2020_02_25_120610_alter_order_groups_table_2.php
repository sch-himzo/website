<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrderGroupsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_groups', function(Blueprint $table){
            $table->boolean('report_spam')->default(0);
            $table->bigInteger('reported_by')->unsigned()->nullable();
            $table->foreign('reported_by')->references('id')->on('users')->onDelete('set null');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_groups', function(Blueprint $table){
            $table->dropColumn('report_spam');
            $table->dropSoftDeletes();
        });
    }
}
