<?php

return [
    /*
     * Whether quick migrations are enabled. If set to disabled you can still use QuickDatabaseMigrations trait
     * and it will behave same as Laravel's DatabaseMigrations.
     */
    'enabled' => env('QUICK_MIGRATIONS_ENABLED', true),

    /*
     * Dump file location.
     */
    'dump_file' => env('QUICK_MIGRATIONS_DUMP_FILE', database_path('dumps') . '/db-test.sql'),
];
