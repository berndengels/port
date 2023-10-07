<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crane_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cranable_type', 50);
            $table->unsignedInteger('cranable_id');
            $table->dateTime('date')->nullable()->index('date');
            $table->date('crane_date');
            $table->time('crane_time')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->index(['cranable_type', 'cranable_id'], 'cranable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crane_dates');
    }
};
