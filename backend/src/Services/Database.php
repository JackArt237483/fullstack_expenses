<?php
namespace App\Services;

use PDO;
use Dotenv\Dotenv;

class DataBase {
    private static ?PDO $pdo = null;

    public static function Connection (array $config): PDO
    {
        // МАССИВ ДЛЯ ПРОВЕРКИ ЗНАЧЕНИЙ
        $requireKeys = ['host', 'port', 'db', 'user', 'password'];
        // Перед подключением мы проверяем, что в $config есть все обязательные ключи.
        foreach ($requireKeys as $key) {
            if (empty($config[$key])) {
                throw new \Exception("Database configuration key {$key} is missing");
            }
        }
        // DSN для подклбчение к БД
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['db']};charset=utf8mb4";

        try {
           return new PDO($dsn, $config['user'], $config['pass'], [
               // НАСТРОЙКА ОШИБОК В ВИДЕ ИСКЛЮЧЕНИЕ
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
               // ПОЛУЧЕМ В ВИДЕ JSON
               PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
               // используем настоящие prepared statements базы, а не эмуляцию в PHP.
               PDO::ATTR_EMULATE_PREPARES => false,
               // ПОЛУЧЕМ В ВИДЕ JSON
               PDO::ATTR_STRINGIFY_FETCHES => false
            ]);
        } catch (\PDOException $e) {
            throw new \Exception("Database something happen");
        }
    }
}
