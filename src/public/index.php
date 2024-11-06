<?php

require '../vendor/autoload.php';

echo 'Testing our Docker setup for UrbanTree <br><br>';

echo 'MySQL connection test: ';
$mysql = new mysqli('mysql', 'demo_user', 'demo_pass', 'demo_db');
$result = $mysql->query('SELECT * FROM demo_table');

while ($row = $result->fetch_assoc()) {
    echo $row['name'] . PHP_EOL;
}
