<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBoatPricesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boat_prices', function (Blueprint $table) {
            $table->foreign('saison_date_id', 'boat_prices_ibfk_1')->references('id')->on('saison_dates')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('price_type_id', 'boat_prices_ibfk_2')->references('id')->on('price_types')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boat_prices', function (Blueprint $table) {
            $table->dropForeign('boat_prices_ibfk_1');
            $table->dropForeign('boat_prices_ibfk_2');
        });
    }
}
