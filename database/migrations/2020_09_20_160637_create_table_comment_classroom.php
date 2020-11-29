<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCommentClassroom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_class', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->String("id_class");
            $table->bigInteger("owner")->unsigned();
            $table->String("comment");
            $table->String("id_status");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_class');
    }
}