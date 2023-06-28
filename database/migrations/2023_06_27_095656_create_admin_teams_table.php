<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo');
            $table->unsignedBigInteger('designation_id');
            $table->string('qualification');
            $table->string('experience');
            $table->tinyInteger('status')->default('1')->comment('1=Active,0=inactive');
            $table->timestamps();
            $table->foreign('designation_id')->references('id')->on('designations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_teams');
    }
}
