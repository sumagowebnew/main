<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGetAQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('get_a_quotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('mobile_no');
            $table->string('email');
            $table->string('service');
            $table->string('address');
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('get_a_quotes');
    }
}
