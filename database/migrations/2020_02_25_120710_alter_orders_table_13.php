<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrdersTable13 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('marked_spam')->default(0);
            $table->bigInteger('marked_by')->unsigned()->nullable();
            $table->foreign('marked_by')->references('id')->on('users')->onDelete('set null');
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('marked_spam');
            $table->dropSoftDeletes();
        });
    }
}
