<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPilsetaToLokacijasTable extends Migration
{
    public function up()
    {
        Schema::table('lokacijas', function (Blueprint $table) {
            $table->string('pilseta')->nullable()->after('adrese');
        });
    }

    public function down()
    {
        Schema::table('lokacijas', function (Blueprint $table) {
            $table->dropColumn('pilseta');
        });
    }
}
