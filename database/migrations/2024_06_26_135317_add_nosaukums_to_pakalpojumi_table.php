<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNosaukumsToPakalpojumiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pakalpojumi', function (Blueprint $table) {
            $table->string('nosaukums')->nullable()->after('pakalpojuma_id'); // Adjust the 'after' method as needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pakalpojumi', function (Blueprint $table) {
            $table->dropColumn('nosaukums');
        });
    }
}
