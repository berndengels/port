<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
/*
        try {
            DB::connection('mysql-test')->getPdo();
        } catch (Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" . $e );
        }
*/
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }
}
