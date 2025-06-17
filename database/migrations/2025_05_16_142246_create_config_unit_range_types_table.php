<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_unit_range_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->enum('type', ['length', 'volume', 'kilogram', 'ton', 'area', 'hour', 'half_hour', 'day', 'absolute', 'kilowatt'])->default('length');
            $table->char('unit', 2)->nullable();

            $table->unique(['name', 'type', 'unit'], 'name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_unit_range_types');
    }
};
