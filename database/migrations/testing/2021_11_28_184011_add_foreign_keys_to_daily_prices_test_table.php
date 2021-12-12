<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDailyPricesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_daily_prices', function (Blueprint $table) {
            $table->foreign('saison_date_id', 'daily_prices_ibfk_1')->references('id')->on('config_saison_dates')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('price_type_id', 'daily_prices_ibfk_2')->references('id')->on('config_price_types')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_daily_prices', function (Blueprint $table) {
            $table->dropForeign('daily_prices_ibfk_1');
            $table->dropForeign('daily_prices_ibfk_2');
        });
    }
}
