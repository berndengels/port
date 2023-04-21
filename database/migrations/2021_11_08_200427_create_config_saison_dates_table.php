<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigSaisonDatesTable extends Migration
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
            $table->string('name', 100)->default('');
            $table->enum('key', ['customer','guest']);
            $table->enum('mode', ['summer','winter'])->nullable();
            $table->unsignedTinyInteger('from_day');
            $table->unsignedTinyInteger('from_month');
            $table->unsignedTinyInteger('until_day');
            $table->unsignedTinyInteger('until_month');
            $table->unsignedSmallInteger('from_mday')->nullable();
            $table->unsignedSmallInteger('until_mday')->nullable();
        });
        DB::statement('ALTER TABLE config_saison_dates CHANGE from_day from_day TINYINT(2) UNSIGNED ZEROFILL NOT NULL');
        DB::statement('ALTER TABLE config_saison_dates CHANGE from_month from_month TINYINT(2) UNSIGNED ZEROFILL NOT NULL');
        DB::statement('ALTER TABLE config_saison_dates CHANGE until_day until_day TINYINT(2) UNSIGNED ZEROFILL NOT NULL');
        DB::statement('ALTER TABLE config_saison_dates CHANGE until_month until_month TINYINT(2) UNSIGNED ZEROFILL NOT NULL');
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
