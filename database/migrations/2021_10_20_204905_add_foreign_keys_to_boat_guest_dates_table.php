<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBoatGuestDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boat_guest_dates', function (Blueprint $table) {
            $table->foreign('boat_guest_id', 'boat_guest_dates_ibfk_1')->references('id')->on('caravans')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boat_guest_dates', function (Blueprint $table) {
            $table->dropForeign('boat_guest_dates_ibfk_1');
        });
    }
}
