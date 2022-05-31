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
            $table->string('name', 50);
            $table->string('address', 255);
            $table->string('phone', 20);
            $table->string('email', 50);
            $table->string('website', 50);
            $table->string('latitude', 20)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->time('open')->nullable();
            $table->time('close')->nullable();
            $table->foreignId('provider_id');
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
