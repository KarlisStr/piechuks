<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePakalpojumiTable extends Migration
{
    public function up()
    {
        Schema::create('pakalpojumi', function (Blueprint $table) {
            $table->increments('pakalpojuma_id');
            $table->string('apraksts', 200);
            $table->string('nosaukums', 50);
            $table->string('kategorijas_nosaukums', 50);
            $table->string('cena', 20);
            $table->unsignedInteger('lokacijas_id')->nullable();
            $table->string('profesionalis_id', 12)->nullable();
            $table->foreign('lokacijas_id')->references('lokacijas_id')->on('lokacijas')->onDelete('set null');
            $table->foreign('profesionalis_id')->references('profesionalis_id')->on('profesionali')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pakalpojumi');
    }
}
