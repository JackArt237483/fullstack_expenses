<?php
namespace App\Services;

use PDO;
use Dotenv\Dotenv;

class DataBase {
    private static ?PDO $pdo = null;

    public static function Connection (): PDO
    {
        if (self::$pdo === null) {
            $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
            $dotenv->load();

            // ПОЛУЧЕНИЕ ДАННЫХ ИЗ .ENV
            $host = $_ENV["DB_HOST"];
            $port = $_ENV["DB_PORT"];
            $db   = $_ENV["DB_NAME"];
            $user = $_ENV["DB_USER"];
            $pass = $_ENV["DB_PASS"];

            // DSN с указанием порта
            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

            self::$pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }

        return self::$pdo;
    }
}
