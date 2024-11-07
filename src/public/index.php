<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Core\Database;

echo 'Testing our Docker setup for UrbanTree <br><br>';

echo 'MySQL connection test: ';

$db = Database::connect();
$result = $db->query('SELECT * FROM demo_table');

while ($row = $result->fetch_assoc()) {
    echo $row['name'] . PHP_EOL;
}