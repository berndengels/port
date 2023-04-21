<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentables', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('rentable');
            $table->unsignedInteger('customer_id')->index('customer_id');
            $table->date('from');
            $table->date('until');
            $table->unsignedInteger('price')->nullable()->index('price');
            $table->longText('prices')->nullable()->index();
            $table->unsignedTinyInteger('is_paid')->default(0)->index('is_paid');
            $table->index(['from', 'until'], 'from');
            $table->index(['rentable_id', 'rentable_type'], 'rentable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rentables');
    }
}
