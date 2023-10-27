<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeviceTypeFieldInSomeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mous', function (Blueprint $table) {
            $table->string('device_type')->after('title');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->string('device_type')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mous', function (Blueprint $table) {
            $table->dropColumn('device_type');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('device_type');
        });
        
    }
}
