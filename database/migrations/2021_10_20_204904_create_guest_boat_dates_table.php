<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestBoatDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_boat_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('guest_boat_id')->index();
            $table->date('from');
            $table->date('until');
            $table->unsignedTinyInteger('persons');
            $table->unsignedTinyInteger('electric')->nullable();
            $table->unsignedInteger('price');
            $table->longText('prices');
            $table->boolean('is_paid')->unsigned()->default(0);
            $table->foreign('guest_boat_id', 'guest_boats_fk')->references('id')->on('guest_boats')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guest_boat_dates');
    }
}
