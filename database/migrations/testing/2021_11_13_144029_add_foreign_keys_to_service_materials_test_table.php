<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToServiceMaterialsTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_materials', function (Blueprint $table) {
            $table->foreign('service_id', 'service_materials_ibfk_1')->references('id')->on('services')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('material_id', 'service_materials_ibfk_2')->references('id')->on('materials')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_materials', function (Blueprint $table) {
            $table->dropForeign('service_materials_ibfk_1');
            $table->dropForeign('service_materials_ibfk_2');
        });
    }
}
