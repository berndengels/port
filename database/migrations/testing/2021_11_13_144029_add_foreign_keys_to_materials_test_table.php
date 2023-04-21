<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMaterialsTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->foreign('material_category_id', 'materials_ibfk_1')
                ->references('id')
                ->on('material_categories')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->foreign('price_type_id', 'materials_ibfk_2')
                ->references('id')
                ->on('config_price_types')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign('materials_ibfk_1');
            $table->dropForeign('materials_ibfk_2');
        });
    }
}
