<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseboatsTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houseboats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('houseboat_model_id');
            $table->string('name', 50);
            $table->foreign('houseboat_model_id', 'houseboat_model_ibfk_1')
                ->references('id')->on('houseboat_models')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE')
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houseboats');
    }
}
