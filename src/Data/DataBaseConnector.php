<?php

namespace App\Data;

use PDO;

class DataBaseConnector {

    private static PDO $connector;

    private final function __construct() {
        echo __CLASS__ . ' initialize only once';
    }

    public static function getConnect(): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;port=%s;charset=%s',
            $_SERVER['DB_HOST'],
            $_SERVER['DB_NAME'],
            $_SERVER['DB_PORT'],
            $_SERVER['DB_CHARSET']
        );
        self::$connector = new PDO($dsn, $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD']);
        self::$connector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$connector->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        self::$connector->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return self::$connector;
    }
}
