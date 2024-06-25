<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtsauksmesTable extends Migration
{
    public function up()
    {
        Schema::create('atsauksmes', function (Blueprint $table) {
            $table->increments('atsauksmes_id');
            $table->string('apraksts', 200);
            $table->integer('reitings');
            $table->unsignedInteger('pieteikums_id')->nullable();
            $table->string('klients_id', 12)->nullable();
            $table->foreign('pieteikums_id')->references('pieteikums_id')->on('pieteikumi')->onDelete('set null');
            $table->foreign('klients_id')->references('klients_id')->on('klienti')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('atsauksmes');
    }
}
