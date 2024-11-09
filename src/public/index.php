<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;

echo 'Testing our Docker setup for UrbanTree <br><br>';

echo 'MySQL connection test: ';
$db = Database::connect();
if ($db) {
    echo 'Success';
} else {
    echo 'Failed';
}

// $result = $mysql->query('SELECT * FROM demo_table');

// while ($row = $result->fetch_assoc()) {
//     echo $row['name'] . PHP_EOL;
// }
