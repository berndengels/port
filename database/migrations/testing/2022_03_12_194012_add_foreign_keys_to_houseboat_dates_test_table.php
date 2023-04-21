<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHouseboatDatesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('houseboat_dates', function (Blueprint $table) {
            $table->foreign('houseboat_id', 'houseboat_dates_ibfk_1')->references('id')->on('houseboats')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('customer_id', 'houseboat_dates_ibfk_2')->references('id')->on('customers')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('houseboats_dates', function (Blueprint $table) {
            $table->dropForeign('houseboats_dates_ibfk_1');
            $table->dropForeign('houseboats_dates_ibfk_2');
        });
    }
}
