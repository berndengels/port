<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseboatOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houseboat_owners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->index();
            $table->string('email', 50);
            $table->string('city', 50);
            $table->string('postcode', 10);
            $table->string('street', 50);
            $table->string('fon', 50);
            $table->string('bank', 50);
            $table->string('iban', 50);
            $table->string('bic', 50);
            $table->timestamps();
            $table->index(['created_at','updated_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houseboat_owners');
    }
}
