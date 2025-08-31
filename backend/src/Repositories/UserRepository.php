<?php
namespace App\Repositories;

use App\DTO\UserDTO;
use PDO;
use PDOException;

class UserRepository implements UserRepositoryInterface{
    private PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    public function findByEmail(string $email): ?UserDTO
    {
        try{
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
            return $data ? UserDTO::fromArray($data) : null;
        }catch (PDOException $e){
            throw new \RuntimeException("Ошибка при поиске юзера". $e->getMessage());
        }
    }
    public function create(UserDTO $user): bool
    {
        // ПРОВЕРКА ПОЛЕЙ НА ОБЯЗАТЬЕЛЬСТВО
        if(empty($user->name) || empty($user->email) || empty($user->passwordHash)){
            throw new \HttpQueryStringException("Все поля обязательны");
        }
        try{
            $pdo = DataBase::Connection();
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');
            $stmt->execute([
                ":name" => $user->name,
                ":email" => $user->email,
                ":password" =>$user->passwordHash
            ]);
        }catch(PDOException $e){
            throw new \RuntimeException("Ошибка при созаднии юзера". $e->getMessage());
        }
    }
}