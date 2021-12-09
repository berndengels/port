<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigSaisonDatesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_saison_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->enum('key', ['customer','guest']);
            $table->enum('mode', ['summer','winter'])->nullable();
            $table->char('from_day', 2);
            $table->char('from_month', 2);
            $table->char('until_day', 2);
            $table->char('until_month', 2);
            $table->unsignedSmallInteger('from_mday')->nullable();
            $table->unsignedSmallInteger('until_mday')->nullable();
        });
/*
        DB::statement('ALTER TABLE config_saison_dates CHANGE from_day from_day TINYINT(2) UNSIGNED ZEROFILL NOT NULL');
        DB::statement('ALTER TABLE config_saison_dates CHANGE from_month from_month TINYINT(2) UNSIGNED ZEROFILL NOT NULL');
        DB::statement('ALTER TABLE config_saison_dates CHANGE until_day until_day TINYINT(2) UNSIGNED ZEROFILL NOT NULL');
        DB::statement('ALTER TABLE config_saison_dates CHANGE until_month until_month TINYINT(2) UNSIGNED ZEROFILL NOT NULL');
*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_saison_dates');
    }
}
