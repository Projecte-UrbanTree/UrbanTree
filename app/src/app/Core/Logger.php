<?php

namespace App\Core;

\Sentry\init([
    'dsn' => getenv('SENTRY_DSN'),
    'environment' => getenv('APP_ENV'),
    'release' => getenv('IMAGE_VERSION'),
    // Specify a fixed sample rate
    'traces_sample_rate' => 1.0,
    // Set a sampling rate for profiling - this is relative to traces_sample_rate
    'profiles_sample_rate' => 1.0,
]);

class Logger
{
    public static function log()
    {
        \Sentry\captureLastError();
    }
}
