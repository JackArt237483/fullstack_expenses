<?php
namespace App\Services;

use PDO;
use Dotenv\Dotenv;
// метод singleton юзаем один обьект чтобы не использовтаь много раз
class DataBase {
 private static ?PDO $pdo = null;
 public static function Connection ():PDO
 {
    if(self::$pdo === null){
        $dotenv = Dotenv::createImmutable(__DIR__ . "../../");
        $dotenv->load();

        // ПОЛУЧЕНИЕ ДАННЫЗ ИЗ .ENV
        $host = $_ENV["DB_HOST"];
        $db = $_ENV["DB_NAME"];
        $user = $_ENV["DB_USER"];
        $pass = $_ENV["DB_PASS"];
        //СОЗДАНИЕ ПОДКЛЮБЧЕНИЯ
       $dsn = "mysql:host=$host;dbname-$db;charset=utf8mb4";

       self::$pdo = new PDO($dsn, $user, $pass,[
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
           // РЕЖИМ ВЫБОРКИ ДАННЫХ ИЗ MYSQL
       ]);
    }
     return self::$pdo;
    // ЕСЛИ ВСЕ НОРМ ТО ПРОСТО ВОЗРАТ ПОДКЛЮЧЕНИЯ
     }
}