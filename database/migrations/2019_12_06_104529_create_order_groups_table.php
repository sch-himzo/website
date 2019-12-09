<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->boolean('internal')->nullable();
            $table->string('comment')->nullable();
            $table->bigInteger('approved_by')->unsigned()->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->bigInteger('temp_user_id')->unsigned()->nullable();
            $table->foreign('temp_user_id')->references('id')->on('temp_users')->onDelete('set null');
            $table->integer('status')->default(0);
            $table->boolean('public_albums')->default(0);
            $table->boolean('archived')->default(0);
            $table->boolean('joint_project')->default(0);
            $table->boolean('help')->default(0);
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
        Schema::dropIfExists('order_groups');
    }
}
