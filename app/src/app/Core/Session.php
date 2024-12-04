<?php

namespace App\Core;

class Session
{
    public static function start()
    {
        session_start();
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        session_destroy();
    }
}
