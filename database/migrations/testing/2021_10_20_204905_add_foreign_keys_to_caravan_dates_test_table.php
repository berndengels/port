<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCaravanDatesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('caravan_dates', function (Blueprint $table) {
            $table->foreign('caravan_id', 'caravan_dates_ibfk_1')->references('id')->on('caravans')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('caravan_dates', function (Blueprint $table) {
            $table->dropForeign('caravan_dates_ibfk_1');
        });
    }
}
