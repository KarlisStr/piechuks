<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReklamaTable extends Migration
{
    public function up()
    {
        Schema::create('reklama', function (Blueprint $table) {
            $table->increments("reklama_id");
            $table->string('apraksts', 200);
            $table->string('majaslapa', 200);
            $table->string('imagepath', 100);
            $table->string('telefons', 50);
            $table->string('admin_id', 12)->nullable();
            $table->foreign('admin_id')->references('admin_id')->on('admins')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reklama');
    }
}
