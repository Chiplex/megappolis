<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yeipi_shops', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('direccion', 200);
            $table->string('latitud', 10)->nullable();
            $table->string('longitud', 10)->nullable();
            $table->time('abre')->nullable();
            $table->time('cierra')->nullable();
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
        Schema::dropIfExists('yeipi_shops');
    }
}
