<?php

class Database
{
    private static $config;
    private static $pdo;

    private static function loadConfig()
    {
        self::$config = parse_ini_file(__DIR__ . '/config.ini', true)['database'];
    }

    public static function conn()
    {
        if (!isset(self::$config)) {
            self::loadConfig();
        }

        if (!isset(self::$pdo)) {
            $host = self::$config['host'];
            $dbname = self::$config['dbname'];
            $dbUsername = self::$config['dbUsername'];
            $dbPassword = self::$config['dbPassword'];

            try {
                $dsn = "mysql:host=" . $host . ";dbname=" . $dbname;
                self::$pdo = new PDO($dsn, $dbUsername, $dbPassword);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                exit('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }

    public static function closeConnection()
    {
        self::$pdo = null;
    }
}
