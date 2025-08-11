<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Services\DataBase;

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = DataBase::Connection();
    // Если подключение успешно
    echo json_encode([
        'status' => 'ok',
        'message' => 'Подключение к базе успешно!',
        'server_info' => $pdo->getAttribute(PDO::ATTR_SERVER_VERSION)
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    // Если ошибка — вернём JSON с описанием
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
