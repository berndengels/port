<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaisonDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saison_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->default('');
            $table->unsignedTinyInteger('from_day');
            $table->unsignedTinyInteger('from_month');
            $table->unsignedTinyInteger('until_day');
            $table->unsignedTinyInteger('until_month');
        });
        DB::statement('ALTER TABLE saison_dates CHANGE from_day from_day TINYINT(2) UNSIGNED ZEROFILL NOT NULL');
        DB::statement('ALTER TABLE saison_dates CHANGE from_month from_month TINYINT(2) UNSIGNED ZEROFILL NOT NULL');
        DB::statement('ALTER TABLE saison_dates CHANGE until_day until_day TINYINT(2) UNSIGNED ZEROFILL NOT NULL');
        DB::statement('ALTER TABLE saison_dates CHANGE until_month until_month TINYINT(2) UNSIGNED ZEROFILL NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saison_dates');
    }
}
