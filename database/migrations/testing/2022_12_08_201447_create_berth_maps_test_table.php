<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerthMapsTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berth_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('berth_id');
            $table->unsignedInteger('w');
            $table->unsignedInteger('h');
            $table->unsignedInteger('x');
            $table->unsignedInteger('y');
            $table->integer('angle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berth_maps');
    }
}
