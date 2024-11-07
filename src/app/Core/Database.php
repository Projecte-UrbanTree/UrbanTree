<?php

namespace App\Core;

class Database
{
    public static function connect()
    {
        $db = new \mysqli('mariadb', 'demo_user', 'demo_pass', 'demo_db');
        $db->set_charset('utf8');
        return $db;
    }
}