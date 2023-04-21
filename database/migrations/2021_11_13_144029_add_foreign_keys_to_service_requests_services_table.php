<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToServiceRequestsServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_requests_services', function (Blueprint $table) {
            $table->foreign('service_request_id', 'service_requests_services_ibfk_1')->references('id')->on('service_requests')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('service_id', 'service_requests_services_ibfk_2')->references('id')->on('services')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_requests_services', function (Blueprint $table) {
            $table->dropForeign('service_requests_services_ibfk_1');
            $table->dropForeign('service_requests_services_ibfk_2');
        });
    }
}
