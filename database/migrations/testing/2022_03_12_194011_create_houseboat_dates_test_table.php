<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseboatDatesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houseboat_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('houseboat_id')->index('houseboat_id');
            $table->date('from');
            $table->date('until');
            $table->unsignedInteger('price');
            $table->longText('prices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houseboats_dates');
    }
}
