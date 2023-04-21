<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigSaisonRentDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_saison_rent_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('config_saison_rent_id')->index('config_saison_rent_id');
            $table->string('name', 50)->nullable();
            $table->string('holiday', 25)->nullable();
            $table->date('from');
            $table->date('until');
            $table->index(['from','until']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_saison_rent_dates');
    }
}
