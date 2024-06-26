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
            $table->string('adrese');
            $table->float('cena', 8, 2);
            $table->string('profesionalis_id', 12)->nullable();
            $table->foreign('profesionalis_id')->references('profesionalis_id')->on('profesionali')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pakalpojumi');
    }
}
