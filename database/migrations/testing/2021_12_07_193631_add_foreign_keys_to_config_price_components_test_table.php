<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToConfigPriceComponentsTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_price_components', function (Blueprint $table) {
            $table->foreign('price_type_id', 'config_price_components_ibfk_1')->references('id')->on('config_price_types')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('config_service_id', 'config_price_components_ibfk_2')->references('id')->on('config_services')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_price_components', function (Blueprint $table) {
            $table->dropForeign('config_price_components_ibfk_1');
            $table->dropForeign('config_price_components_ibfk_2');
        });
    }
}
