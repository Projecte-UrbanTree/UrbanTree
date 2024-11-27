<?php

use App\Core\Database;
use App\Core\Logger;
use App\Core\Session;

// Start session
Session::start();

// Connect to the database
Database::connect();

// TODO: Set up global error handler
// set_error_handler(function ($severity, $message, $file, $line) {
//     Logger::log("Error: {$message} in {$file} on line {$line}");
// });
