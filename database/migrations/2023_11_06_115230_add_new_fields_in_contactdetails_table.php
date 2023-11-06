<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsInContactdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_details', function (Blueprint $table) {
            $table->string('title')->after('address');
            $table->string('image')->after('address');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_details', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('image');
        });
    }
}
