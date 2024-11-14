<?php

namespace App\Core;

class Logger
{
    public static function log($message, $level = 'info')
    {
        // $logFile = getenv("LOG_FILE_PATH");
        // $logMessage = strtoupper($level) . ' - ' . date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;
        // if (!file_exists($logFile)) {
        //     touch($logFile);
        // }
        //file_put_contents($logFile, $logMessage, FILE_APPEND);
    }    
}

