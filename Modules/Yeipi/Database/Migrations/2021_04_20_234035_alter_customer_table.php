<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('yeipi_customers', function (Blueprint $table) {
            $table->string('direccion', 200)->nullable();
            $table->string('latitud', 10)->nullable();
            $table->string('longitud', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yeipi_customers', function (Blueprint $table) {
            $table->dropColumn('direccion');
            $table->dropColumn('latitud');
            $table->dropColumn('longitud');
        });
    }
}
