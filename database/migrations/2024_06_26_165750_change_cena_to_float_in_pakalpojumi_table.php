<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCenaToFloatInPakalpojumiTable extends Migration
{
    public function up()
    {
        Schema::table('pakalpojumi', function (Blueprint $table) {
            $table->float('cena', 8, 2)->change();
        });
    }

    public function down()
    {
        Schema::table('pakalpojumi', function (Blueprint $table) {
            $table->string('cena')->change();
        });
    }
}
