<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoatDatesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boat_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('boat_id')->index('boat_id');
            $table->enum('modus', ['summer', 'winter'])->default('summer');
            $table->date('from');
            $table->date('until');
            $table->unsignedInteger('price');
            $table->longText('prices');
            $table->boolean('is_paid')->unsigned()->default(0);
            $table->index(['from', 'until'], 'from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boat_dates');
    }
}
