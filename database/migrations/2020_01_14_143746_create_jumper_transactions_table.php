<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJumperTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jumper_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('fulfilled')->default(0);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('temp_user_id')->unsigned()->nullable();
            $table->foreign('temp_user_id')->references('id')->on('temp_users')->onDelete('set null');
            $table->bigInteger('jumper_type_id')->unsigned();
            $table->foreign('jumper_type_id')->references('id')->on('jumper_types')->onDelete('cascade');
            $table->unsignedInteger('count');
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
        Schema::dropIfExists('jumper_transactions');
    }
}
