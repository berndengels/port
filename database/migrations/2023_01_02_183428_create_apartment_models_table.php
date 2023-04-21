<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->default('');
            $table->text('description');
            $table->unsignedInteger('space');
            $table->unsignedTinyInteger('floors');
            $table->unsignedTinyInteger('sleeping_places');
            $table->unsignedInteger('peak_season_price')->nullable();
            $table->unsignedInteger('mid_season_price')->nullable();
            $table->unsignedInteger('low_season_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartment_models');
    }
}
