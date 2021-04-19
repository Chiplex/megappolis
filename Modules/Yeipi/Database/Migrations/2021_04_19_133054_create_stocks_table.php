<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yeipi_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('shop_id');
            $table->decimal('precio', 5, 2)->nullable();
            $table->decimal('stock', 5, 2)->nullable()->default(1);
            $table->string('medida', 20)->nullable();
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
        Schema::dropIfExists('yeipi_stocks');
    }
}
