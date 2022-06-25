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
            $table->string('number', 10)->default('')->index();
            $table->decimal('width', 3, 1)->unsigned()->nullable();
            $table->decimal('length', 3, 1)->unsigned()->nullable();
            $table->decimal('daily_price', 5, 2)->unsigned()->nullable()->index();
            $table->float('lat', 10, 0)->unsigned()->nullable();
            $table->float('lng', 10, 0)->nullable();
            $table->boolean('enabled')->default(1)->index();
            $table->index(['lat','lng']);
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
