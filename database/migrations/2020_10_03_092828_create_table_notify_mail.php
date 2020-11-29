<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableNotifyMail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify_mail', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger("recipient")->unsigned();
            $table->bigInteger("sender")->unsigned();
            $table->String("id_class");
            $table->String("type");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notify_mail');
    }
}