<?php

use Config\Database;

if (!function_exists('h_connect_database')) {
    function h_connect_database($dbName)
    {
        $dbConfig = config('Database');

        // Copy the default database configuration
        $dynamicDbConfig = $dbConfig->default;

        // Override the database name
        $dynamicDbConfig['database'] = $dbName;

        // Create a new database connection instance
        return Database::connect($dynamicDbConfig);
    }
}
