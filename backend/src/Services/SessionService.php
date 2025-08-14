<?php
    // КЛАСС УПАРВЛЕНИЕ СЕССИЯМИ 
    namespace App\Services;
    use App\Services\DataBase;

    class SessionService{
        // генерация токена
        public static function generateToken(){
            return bin2hex(random_bytes(32));
        }
        // функция создания сессии в базу с жизнеспособностью 30 дней 
        public static function create(string $token, int $user_id){
            $pdo = DataBase::Connection();
            $stmt = $pdo->prepare('INSERT INTO sessions (token,user_id,expires_at) VALUES (?,?,?)');
            $stmt->execute([
                $token,
                $user_id,
                date("Y-m-d H:i:s",strtotime('+30 days'))
                // форматация даты и прибавка 30 дней 
            ]);
        }
        // ФУНКЦИЯ ДЯЛ ПОРЛУЧЕНИЯ ID БЗЕРА ИЗ СЕССИИ
        public static function getUserById(string $token){
            $pdo = DataBase::Connection();
            // ВЫБЕРИ МНЕ ID ЮЗЕРА И ПОДСЬАВЬ ЕГО ТОКЕН И ЕСЛИ ЕГО СЕСССИЯ ЕЩЕ НЕ ИСТЕКЛА 
            $stmt = $pdo->prepare("SELECT user_id FROM sessions WHERE token = ? AND expires_at > NOW()");
            $stmt->execute([$token]); // подставляет токен в ?
            // ПОЛУЧАЕМ ПЕРВУЮ ЗАПИСЬ В ТАБЛИЦЕ 
            $row = $stmt->fetch();
            return $row ? (int)$row['user_id'] : null;
        }
        // ФУНКЦИЯ УДЛАЕНИЯ СЕСИИИ И ЮЗЕРА ИЗ БД
        public static function revoke(string $token) {
            $pdo = DataBase::Connection();
            $stmt = $pdo->prepare('DELETE FROM sessions WHERE token = ?');
            $stmt->execute([$token]);
        }
    }
?>