<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->default('')->index('name');
            $table->string('email', 50)->default('')->index('email');
            $table->string('subject', 100)->nullable();
            $table->text('message');
            $table->timestamp('created_at')->index('created_at');
            $table->fullText(['subject', 'message'], 'subject-message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
