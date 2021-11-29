<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoatPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boat_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('saison_date_id')->index('saison_date_id');
            $table->unsignedInteger('price_type_id')->index('price_type_id');
            $table->float('price_factor', 10, 0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boat_prices');
    }
}
