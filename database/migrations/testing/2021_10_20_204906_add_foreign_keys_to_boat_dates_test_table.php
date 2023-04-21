<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBoatDatesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boat_dates', function (Blueprint $table) {
            $table->foreign('boat_id', 'boat_dates_ibfk_1')->references('id')->on('boats')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boat_dates', function (Blueprint $table) {
            $table->dropForeign('boat_dates_ibfk_1');
        });
    }
}
