<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableClassDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger("owner")->unsigned();
            $table->String("id_class");
            $table->String("content");
            $table->String("description")->nullable();
            $table->date("deadline")->nullable();
            $table->String("state")->default("none");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_details');
    }
}