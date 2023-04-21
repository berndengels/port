<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('material_category_id')->index('material_category_id');
            $table->unsignedInteger('price_type_id')->index('price_type_id');
            $table->string('name', 100)->default('');
            $table->decimal('price_per_unit', 10)->unsigned();
            $table->decimal('fertility', 11)->unsigned()->nullable();
            $table->enum('fertility_per', ['Meter', 'Quadratmeter', 'Liter'])->nullable()->default('Meter');
            $table->enum('fertility_unit', ['Meter', 'Quadratmeter', 'Liter'])->nullable()->default('Meter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
