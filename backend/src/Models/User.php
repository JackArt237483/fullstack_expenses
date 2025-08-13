<?php
    // КЛАСС ЮЗЕРА
    namespace App\Models;

    use App\Services\DataBase;
    use PDO;

    class User {
        // функция поиска email
        public static function findByEmail(string $email):?array{
            $pdo = DataBase::Connection();
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        }
        // фунекция создания пользователя
        public static function create( string $name, string $email, string $passwordHash){
            $pdo = DataBase::Connection();
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');
            $stmt->execute([
                ":name" => $name,
                ":email" => $email,
                ":password" =>$passwordHash
            ]);
        }
    }
?>