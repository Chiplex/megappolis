<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yeipi_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("people_id");
            $table->string('address', 200)->nullable();
            $table->string('latitude', 10)->nullable();
            $table->string('longitude', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yeipi_customers');
    }
}
