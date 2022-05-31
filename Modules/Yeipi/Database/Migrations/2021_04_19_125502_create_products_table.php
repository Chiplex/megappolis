<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yeipi_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId("category_id");
            $table->string('name', 255);
            $table->string('description', 255)->nullable();
            $table->string('packingUnit', 10);
            $table->string('measureUnit', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yeipi_products');
    }
}
