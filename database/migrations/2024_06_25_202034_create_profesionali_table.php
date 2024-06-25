<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesionaliTable extends Migration
{
    public function up()
    {
        Schema::create('profesionali', function (Blueprint $table) {
            $table->string('profesionalis_id', 12)->primary();
            $table->string('vards_uzvards', 50);
            $table->string('epasts', 50);
            $table->string('telefons', 50);
            $table->string('bankas_konts', 50);
            $table->integer('statuss');
            $table->unsignedBigInteger('user_id');
            $table->string('admin_id', 12)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('admin_id')->on('admins')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profesionali');
    }
}
