<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlientiTable extends Migration
{
    public function up()
    {
        Schema::create('klienti', function (Blueprint $table) {
            $table->string('klients_id', 12)->primary();
            $table->string('vards_uzvards', 50);
            $table->string('epasts', 50);
            $table->string('telefons', 50)->nullable();
            $table->string('bankas_konts', 50)->nullable();
            $table->integer('statuss')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('profile_imagepath', 255)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('klienti');
    }
}
