<?php

use database\databaseConnector;

require_once __DIR__ . "/../database/databaseConnector.php";
require_once __DIR__ . "/../src/exceptions/dbConnectException.php";

echo 'Hello World!';

$connection = new databaseConnector();
try {
    $connection->createConnection();
    echo "Connection created";
} catch (dbConnectException $e) {
    echo $e->getMessage();
}

