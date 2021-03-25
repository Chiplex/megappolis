<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('header')->nullable();
            $table->foreignId('page_id');
           
            $table->dropColumn('navigable');
            $table->dropColumn('load');
            $table->dropColumn('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('header');
            $table->dropColumn('page_id');
            
            $table->boolean('navigable')->nullable();
            $table->boolean('load')->nullable();
            $table->boolean('title')->nullable();
        });
    }
}
