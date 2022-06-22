<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBerthsIdToGuestBoatDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guest_boat_dates', function (Blueprint $table) {
            $table->addColumn('int', 'guest_boat_berth_id')
                ->unsigned()
                ->index()
                ->after('guest_boat_id');
            $table->foreign('guest_boat_berth_id', 'guest_boat_berth_ibfk_1')
                ->references('id')
                ->on('guest_boat_berths')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
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
            $table->dropColumn('guest_boat_berth_id');
        });
    }
}
