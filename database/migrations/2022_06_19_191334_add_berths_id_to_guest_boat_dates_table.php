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
            $table->addColumn('integer', 'berth_id')
                ->unsigned()
                ->index()
                ->after('guest_boat_id')
                ->nullable(true)
                ->default(null)
            ;
            $table->foreign('berth_id', 'berth_ibfk_1')
                ->references('id')
                ->on('berths')
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
            $table->dropColumn('berth_id');
        });
    }
}
