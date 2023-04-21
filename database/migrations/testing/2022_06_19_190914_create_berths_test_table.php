<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerthsTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berths', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dock_id');
            $table->unsignedInteger('berth_category_id');
            $table->string('number', 10)->default('');
            $table->decimal('width', 3, 1)->unsigned()->nullable();
            $table->decimal('length', 3, 1)->unsigned()->nullable();
            $table->decimal('daily_price', 5)->unsigned()->nullable();
            $table->double('lat')->unsigned()->nullable();
            $table->double('lng')->nullable();
            $table->boolean('enabled')->default(1);
            $table->foreign('dock_id', 'dock_id_ibfk_1')
                ->references('id')
                ->on('docks')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE')
            ;
            $table->foreign('berth_category_id', 'berth_category_id_ibfk_1')
                ->references('id')
                ->on('berth_categories')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE')
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berths');
    }
}
