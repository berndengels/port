<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->enum('boat_type', ['motor', 'sail'])->default('motor');
            $table->string('boat_name', 50)->default('')->unique('carnumber');
            $table->decimal('length', 3, 1)->unsigned()->nullable();
            $table->decimal('width', 2, 1)->unsigned()->nullable();
            $table->unsignedInteger('weight')->nullable();
            $table->unsignedTinyInteger('mast_length')->nullable();
            $table->unsignedInteger('mast_weight')->nullable();
            $table->decimal('draft', 2, 1)->unsigned()->nullable();
            $table->decimal('length_waterline', 3, 1)->unsigned()->nullable();
            $table->decimal('length_keel', 3, 1)->unsigned()->nullable();
            $table->string('home_port', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boats');
    }
}
