<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->default('');
            $table->decimal('lat', 10, 8)->unsigned();
            $table->decimal('lng', 10, 8)->unsigned();
            $table->string('street', 50)->default('');
            $table->string('location', 50)->default('');
            $table->string('postcode', 10)->default('');
            $table->string('email', 100)->nullable();
            $table->string('fon', 50)->nullable();
            $table->string('bank', 50)->nullable();
            $table->string('bic', 50)->nullable();
            $table->string('iban', 50)->nullable();
            $table->float('tax')->unsigned()->default(0);
            $table->boolean('use_tax')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_settings');
    }
}
