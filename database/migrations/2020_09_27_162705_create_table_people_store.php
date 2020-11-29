<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePeopleStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_store', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger("id_people_assignment")->unsigned();
            $table->String("name_file");
            $table->String("type");
            $table->string("base_name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people_store');
    }
}