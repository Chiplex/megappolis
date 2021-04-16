<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('yeipi_orders', function (Blueprint $table) {
            $table->dateTime('fechaRecepcion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yeipi_orders', function (Blueprint $table) {
            $table->dropColumn('fechaRecepcion');
        });
    }
}
