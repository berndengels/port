<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigPriceComponentsTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_price_components', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('price_type_id');
            $table->unsignedInteger('config_service_id')->nullable();
            $table->string('name', 50)->default('');
            $table->string('key', 50)->default('');
            $table->unsignedTinyInteger('unit_inclusive')->nullable();
            $table->decimal('unit_price', 10)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_price_components');
    }
}
