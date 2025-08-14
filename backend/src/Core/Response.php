<?php
// КЛАСС ДЛЯ ОТПРАВКИ JSON ИЗ СЕРВЕРА
namespace App\Core;

class Response {
    public static function json(array $data, int $code = 200){
        http_response_code($code); // УСТАНОВКА HTTP СТАТУСОВ
        header("Content-Type: application/json; charset=utf-8"); // ГОВОРИМ: JSON только
        echo json_encode($data, JSON_UNESCAPED_UNICODE); // ПРЕОБРАЗУЕМ В JSON
        exit(); // ОСТАНАВЛИВАЕМ СКРИПТ
    }
}
