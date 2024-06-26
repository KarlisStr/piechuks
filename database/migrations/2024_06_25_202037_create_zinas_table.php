<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZinasTable extends Migration
{
    public function up()
    {
        Schema::create('zinas', function (Blueprint $table) {
            $table->increments('zina_id');
            $table->string('saturs', 500);
            $table->timestamp('laiks');
            $table->unsignedInteger('chat_id')->nullable();
            $table->string('sutitajs_klients_id', 12)->nullable();
            $table->string('sutitajs_admin_id', 12)->nullable();
            $table->string('sutitajs_profesionalis_id', 12)->nullable();
            $table->foreign('chat_id')->references('chat_id')->on('chats')->onDelete('set null');
            $table->foreign('sutitajs_klients_id')->references('klients_id')->on('klienti')->onDelete('set null');
            $table->foreign('sutitajs_admin_id')->references('admin_id')->on('admin')->onDelete('set null');
            $table->foreign('sutitajs_profesionalis_id')->references('profesionalis_id')->on('profesionali')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('zinas');
    }
}

