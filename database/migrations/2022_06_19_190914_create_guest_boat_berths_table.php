<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestBoatBerthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_boat_berths', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('boat_dock_id')->index('boat_dock_id');
            $table->string('number', 10)->default('')->index();
            $table->decimal('width', 3, 1)->unsigned()->nullable();
            $table->decimal('length', 3, 1)->unsigned()->nullable();
            $table->decimal('daily_price', 5, 2)->unsigned()->nullable()->index();
            $table->double('lat')->unsigned()->nullable();
            $table->double('lng')->nullable();
            $table->boolean('enabled')->default(1)->index();
            $table->index(['lat','lng']);
            $table->foreign('boat_dock_id', 'boat_dock_id_ibfk_1')
                ->references('id')
                ->on('boat_docks')
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
        Schema::dropIfExists('guest_boat_berths');
    }
}
