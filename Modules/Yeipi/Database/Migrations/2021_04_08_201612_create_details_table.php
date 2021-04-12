<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yeipi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id");
            $table->string('descripcion', 100);
            $table->integer('cantidad')->unsigned()->default(1);
            $table->decimal('precio', $precision = 8, $scale = 4);
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
        Schema::dropIfExists('yeipi_details');
    }
}
