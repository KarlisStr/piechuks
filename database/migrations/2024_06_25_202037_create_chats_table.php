<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->increments('chat_id');
            $table->string('admin_id_user1', 12)->nullable();
            $table->string('klienti_id_user1', 12)->nullable();
            $table->string('profesionalis_id_user1', 12)->nullable();
            $table->string('admin_id_user2', 12)->nullable();
            $table->string('klienti_id_user2', 12)->nullable();
            $table->string('profesionalis_id_user2', 12)->nullable();
            $table->foreign('admin_id_user1')->references('admin_id')->on('admins')->onDelete('set null');
            $table->foreign('klienti_id_user1')->references('klients_id')->on('klienti')->onDelete('set null');
            $table->foreign('profesionalis_id_user1')->references('profesionalis_id')->on('profesionali')->onDelete('set null');
            $table->foreign('admin_id_user2')->references('admin_id')->on('admins')->onDelete('set null');
            $table->foreign('klienti_id_user2')->references('klients_id')->on('klienti')->onDelete('set null');
            $table->foreign('profesionalis_id_user2')->references('profesionalis_id')->on('profesionali')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
