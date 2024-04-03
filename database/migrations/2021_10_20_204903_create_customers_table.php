<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['guest','permanent','houseboat','house','apartment'])->default('guest')->index('type');
            $table->string('name', 50)->default('');
            $table->string('email', 50)->nullable()->default('');
            $table->string('password', 100)->nullable()->default('');
            $table->rememberToken();
            $table->string('fon', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('street', 50)->nullable();
            $table->string('postcode', 20)->nullable();
            $table->string('city', 50)->nullable();
            $table->unsignedTinyInteger('confirmed')->nullable();
            $table->index(['email','password'], 'email_password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
