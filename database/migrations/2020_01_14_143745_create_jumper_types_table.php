<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJumperTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jumper_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('size',['XS','S','M','L','XL','XXL','3XL','4XL','5XL']);
            $table->enum('color', ['original','blue','black','red','yellow','white','green','grey','black-grey']);
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
        Schema::dropIfExists('jumper_types');
    }
}
