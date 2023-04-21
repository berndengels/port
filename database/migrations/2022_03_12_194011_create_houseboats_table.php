<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseboatsTable extends Migration
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
            $table->unsignedInteger('houseboat_model_id')->index('houseboat_model_id');
            $table->unsignedInteger('houseboat_owner_id')->index('houseboat_owner_id');
            $table->string('name', 50);
            $table->string('calendar_color', 20)->nullable();
            $table->foreign('houseboat_model_id', 'houseboat_model_ibfk_1')
                ->references('id')->on('houseboat_models')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE')
            ;
            $table->foreign('houseboat_owner_id', 'houseboat_owner_ibfk_1')
                ->references('id')->on('houseboat_owners')
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
