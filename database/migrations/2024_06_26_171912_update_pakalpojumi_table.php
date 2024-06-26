<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePakalpojumiTable extends Migration
{
    public function up()
    {
        Schema::table('pakalpojumi', function (Blueprint $table) {
            $table->string('adrese')->nullable();

        });
    }

    public function down()
    {
        Schema::table('pakalpojumi', function (Blueprint $table) {
            $table->dropColumn(['adrese']);
        });
    }
}
