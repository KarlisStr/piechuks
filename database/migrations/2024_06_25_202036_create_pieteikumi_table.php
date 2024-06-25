<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePieteikumiTable extends Migration
{
    public function up()
    {
        Schema::create('pieteikumi', function (Blueprint $table) {
            $table->increments('pieteikums_id');
            $table->dateTime('laiks');
            $table->string('apraksts', 200);
            $table->unsignedInteger('pakalpojuma_id')->nullable();
            $table->string('klients_id', 12)->nullable();
            $table->integer('statuss');
            $table->foreign('pakalpojuma_id')->references('pakalpojuma_id')->on('pakalpojumi')->onDelete('set null');
            $table->foreign('klients_id')->references('klients_id')->on('klienti')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pieteikumi');
    }
}
