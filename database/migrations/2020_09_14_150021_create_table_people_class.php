<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePeopleClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_class', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->String('id_class');
            $table->bigInteger("id_people")->unsigned();
        });

        Schema::table('people_class', function (Blueprint $table) {
            $table->foreign("id_people")->references("id")->on("users");
            $table->foreign("id_class")->references("id")->on("classroom");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people_class');
    }
}