<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarLicensePlatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_license_plates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id')->index('country_id');
            $table->string('code', 10)->default('')->index('code');
            $table->string('location', 50)->default('')->index('location');
            $table->string('district', 300)->default('');
            $table->string('state')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_license_plates');
    }
}
