<?php
// DI контейнер для управлениеям зависимостями
use Dotenv\Dotenv;
// создается точка входа дял загрузки переменных
$dontenv = Dotenv::createImmutable(__DIR__);
// загружаем все необходимые переменные с .ENV файла
$dontenv->load();
// конфиг дял подключения
$dbConfig = [
    'host' => $_ENV['DB_HOST'] ?? '',
    'port' => $_ENV['DB_PORT'] ?? '',
    'dbname' => $_ENV['DB_NAME'] ?? '',
    'user' => $_ENV['DB_USER'] ?? '',
    'password' => $_ENV['DB_PASS'] ?? '',
];
