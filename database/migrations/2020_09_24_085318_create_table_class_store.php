<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableClassStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_store', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger("id_status")->unsigned();
            $table->String('name_file');
            $table->String("type");
            $table->String("base_name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}