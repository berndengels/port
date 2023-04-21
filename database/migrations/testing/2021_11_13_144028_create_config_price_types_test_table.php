<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigPriceTypesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_price_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->enum('type', ['length', 'volume', 'weight', 'time', 'area'])->default('length');
            $table->char('unit', 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_price_types');
    }
}
