<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToConfigSaisonRentDatesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_saison_rent_dates', function (Blueprint $table) {
            $table->foreign('config_saison_rent_id', 'config_saison_rent_dates_ibfk_1')->references('id')->on('config_saison_rents')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_saison_rent_dates', function (Blueprint $table) {
            $table->dropForeign('config_saison_rent_dates_ibfk_1');
        });
    }
}
