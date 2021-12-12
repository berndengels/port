<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigDailyPricesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_daily_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model', 100)->default('')->index('has_daily_price_type');
            $table->unsignedInteger('saison_date_id')->index('saison_date_id');
            $table->unsignedInteger('price_type_id')->index('price_type_id');
            $table->float('from_unit')->unsigned()->nullable()->default(null);
            $table->float('until_unit')->unsigned()->nullable()->default(null);
            $table->decimal('price')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_daily_prices');
    }
}
