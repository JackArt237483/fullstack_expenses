<?php
    // КЛАСС УПАРВЛЕНИЕ СЕССИЯМИ 
    namespace App\Services;
    use App\Services\DataBase;

    class SessionService{
        // генерация токена
        public static function generateToken(){
        }
        // функция создания сессии в базу с жизнеспособностью 30 дней 
        public static function create(string $token, int $user_id){
            $pdo = DataBase::Connection();
        }
        // ФУНКЦИЯ ДЯЛ ПОРЛУЧЕНИЯ ID БЗЕРА ИЗ СЕССИИ
        public static function getUserById(string $token){
        }
        // ФУНКЦИЯ УДЛАЕНИЯ СЕСИИИ И ЮЗЕРА ИЗ БД
        public static function revoke(string $token) {
        }
    }
?>