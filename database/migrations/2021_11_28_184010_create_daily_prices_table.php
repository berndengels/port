<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('affordable_id')->index('has_daily_price_id');
            $table->string('affordable_type', 100)->default('')->index('has_daily_price_type');
            $table->unsignedInteger('saison_date_id')->index('saison_date_id');
            $table->unsignedInteger('price_type_id')->index('price_type_id');
            $table->float('from_unit', 10, 0)->unsigned()->nullable();
            $table->float('until_unit', 10, 0)->unsigned()->nullable();
            $table->decimal('day_price', 4)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_prices');
    }
}
