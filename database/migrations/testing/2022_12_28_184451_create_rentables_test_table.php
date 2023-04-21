<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentablesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentables', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('rentable');
            $table->unsignedInteger('customer_id');
            $table->date('from');
            $table->date('until');
            $table->unsignedInteger('price')->nullable();
            $table->longText('prices')->nullable();
            $table->unsignedTinyInteger('is_paid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rentables');
    }
}
