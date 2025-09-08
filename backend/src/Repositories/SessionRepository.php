<?php
namespace App\Repositories;

use App\Interfaces\SessionInterface;
use PDO;

class SessionRepository implements SessionInterface{
    private PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    public function generateToken(): string // ГЕНЕАРАИЦЯ ТОКЕНА
    {
        return bin2hex(random_bytes(32));
    }
    public function create(string $token, int $user_id) // СОЗДАНИИ СЕССИИ
    {
        // проверка пользователя и токена
        if(empty($token) || $user_id < 0){
            throw new \InvalidArgumentException('Токен не валидный или ID юзера не понятен');
        }
        try {
            $stmt = $this->pdo->prepare('INSERT INTO sessions (token,user_id,expires_at) VALUES (?,?,?)');
            $stmt->execute([
                $token,
                $user_id,
                date("Y-m-d H:i:s",strtotime('+30 days'))
                // форматация даты и прибавка 30 дней
            ]);
        }catch (\PDOException $e){
            throw new \RuntimeException(("Ошибка при созаднии сессии "), $e->getMessage());
        }
    }
    public function getUserByIdToken($token): ?int
    {
        // Проверка на наличие токена
       if(empty($token)){
           throw new \InvalidArgumentException('Бро токена нет');
       }
       try{
           // ВЫБЕРИ МНЕ ID ЮЗЕРА И ПОДСЬАВЬ ЕГО ТОКЕН И ЕСЛИ ЕГО СЕСССИЯ ЕЩЕ НЕ ИСТЕКЛА
           $stmt = $this->pdo->prepare("SELECT user_id FROM sessions WHERE token = ? AND expires_at > NOW()");
           $stmt->execute([$token]); // подставляет токен в ?
           // ПОЛУЧАЕМ ПЕРВУЮ ЗАПИСЬ В ТАБЛИЦЕ
           $row = $stmt->fetch();
           return $row ? (int)$row['user_id'] : null;
       }catch (\PDOException $e){
           throw new \RuntimeException(("Ошибка при созаднии токена"), $e->getMessage());
       }
    }
    public function revoke(string $token)
    {
        // Проверка на наличие токена
        if(empty($token)){
            throw new \InvalidArgumentException('<Бро токена нет провал');
        }
        // Обработка ошибок
        try {
            $stmt = $this->pdo->prepare('DELETE FROM sessions WHERE token = ?');
            $stmt->execute([$token]);
        }catch (\PDOException $e){
            throw new \RuntimeException("Ошибка при удалении токена", $e->getMessage());
        }
    }
}