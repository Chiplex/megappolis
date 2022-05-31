<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yeipi_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("shop_id");
            $table->foreignId("delivery_id");
            $table->decimal('amount', 5, 2)->nullable()->default(2.0);
            $table->date('start_at');
            $table->date('end_at');
            $table->string('comment', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yeipi_shop_delivery');
    }
}
