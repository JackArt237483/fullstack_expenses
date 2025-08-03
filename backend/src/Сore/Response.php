<?php
    // КЛАСС ДЛЯ ОТПРАВКИ JSON ИЗ СЕРВЕРА 
    namespace App\Core;

    class Response {
        public static function json(array $data, int $code = 200){
            // УСТАНОВКА HTTP СТАТУСОВ
            http_response_code($code);
            // ЗДЕСЬ КЛИНТУ ГОВОРИМ ТОЛЬКО В JSON ПРИМНМАЙ 
            header("Content-type: application/json");
            // МЕНЯЕМ НА JSON 
            echo json_encode($data);
            // ВЫХОД ИЗ СКРИПТА 
            exit();
        }
    }
?>