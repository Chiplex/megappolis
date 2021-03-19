<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeoplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peoples', function (Blueprint $table) {
            $table->id();
            $table->string("tipo", 20);
            $table->string('name', 50);
            $table->string('otherName', 50)->nullable();
            $table->string('lastName', 50);
            $table->string('otherLastName', 50)->nullable();
            $table->date('dateBirth');
            $table->string('country', 20);
            $table->string('city', 20);
            $table->string('phone', 20);
            $table->string('sex', 20);
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
        Schema::dropIfExists('peoples');
    }
}
