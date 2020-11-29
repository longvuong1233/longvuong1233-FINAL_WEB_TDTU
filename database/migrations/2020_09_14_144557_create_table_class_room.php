<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableClassRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom', function (Blueprint $table) {
            $table->String("id")->primary();
            $table->timestamps();
            $table->bigInteger("id_owner")->unsigned();
            $table->string("nameclass");
            $table->String('part');
            $table->String('title');
            $table->string('room');
            $table->string('img')->default("1HZxFec4BbvDCavG6uaPvjcYoAQAHEEWZ");
        });

        Schema::table('classroom', function (Blueprint $table) {
            $table->foreign('id_owner')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom');
    }
}