<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLokacijasTable extends Migration
{
    public function up()
    {
        Schema::create('lokacijas', function (Blueprint $table) {
            $table->increments('lokacijas_id');
            $table->string('adrese', 150);
            $table->string('apraksts', 200);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lokacijas');
    }
}
