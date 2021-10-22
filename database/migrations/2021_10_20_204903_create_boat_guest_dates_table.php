<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoatGuestDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boat_guest_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('boat_guest_id')->index('caravan_id');
            $table->date('from');
            $table->date('until');
            $table->unsignedTinyInteger('persons');
            $table->unsignedTinyInteger('electric')->nullable();
            $table->unsignedInteger('day_price')->nullable();
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
        Schema::dropIfExists('boat_guest_dates');
    }
}
