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
        Schema::table('guest_boat_dates', function (Blueprint $table) {
            $table->foreign('guest_boat_id', 'guest_boat_dates_ibfk_1')
                ->references('id')
                ->on('guest_boats')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE')
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guest_boat_dates', function (Blueprint $table) {
            $table->dropForeign('guest_boat_dates_ibfk_1');
        });
    }
}
