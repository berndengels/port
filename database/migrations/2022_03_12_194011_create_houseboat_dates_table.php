<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseboatDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houseboat_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('houseboat_id')->index('houseboat_id');
            $table->unsignedInteger('customer_id')->index('customer_id');
            $table->date('from')->index('from');
            $table->date('until')->index('until');
            $table->unsignedInteger('price');
            $table->longText('prices');
            $table->boolean('is_paid')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houseboats_dates');
    }
}
