<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->foreign('service_category_id', 'services_ibfk_1')->references('id')->on('service_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('price_type_id', 'services_ibfk_2')->references('id')->on('config_price_types')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign('services_ibfk_1');
            $table->dropForeign('services_ibfk_2');
        });
    }
}
