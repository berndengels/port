<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip', 20)->default('');
            $table->string('city', 50)->default('')->index('city');
            $table->string('country', 50)->default('');
            $table->string('state', 50)->default('');
            $table->string('postal_code', 20)->default('');
            $table->string('user_agent', 255)->default('');
            $table->timestamp('created_at')->useCurrent()->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_logs');
    }
}
