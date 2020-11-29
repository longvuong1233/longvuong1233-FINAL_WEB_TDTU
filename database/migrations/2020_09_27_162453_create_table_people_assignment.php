<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePeopleAssignment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_assignment', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger("id_people")->unsigned();
            $table->bigInteger("id_status")->unsigned();
            $table->String("state");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people_assignment');
    }
}