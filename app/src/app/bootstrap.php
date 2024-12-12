<?php

use App\Core\Database;
use App\Core\Logger;
use App\Core\Session;

// Start session
Session::start();

// Set the error handler
set_error_handler(function () {
    Logger::log();
});

// Connect to the database
Database::connect();
