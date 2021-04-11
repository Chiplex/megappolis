<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yeipi_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId("customer_id");
            $table->foreignId("contract_id");
            $table->dateTime('fechaSolicitud');
            $table->dateTime('fechaSalida')->nullable();
            $table->dateTime('fechaEntrega')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
