<?php
    // КЛАСС ЮЗЕРА
    namespace App\Models;

    use App\Services\DataBase;
    use PDO;

    class User {
        // функция поиска email
        public static function findByEmail(string $email):?array{
            $pdo = DataBase::Connection();
        }
        // фунекция создания пользователя
        public static function create( string $name, string $email, string $passwordHash){
        }
    }
?>