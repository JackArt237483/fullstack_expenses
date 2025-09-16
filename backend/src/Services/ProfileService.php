<?php
// Метод для работы с профилем юзера
namespace App\Services;

use App\DTO\UserDTO;
use App\Interfaces\UserInterface;

class ProfileService {
    private UserInterface $userRepo;
    public function __construct(UserInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function updateProfile(int $id,string $name,string $email):array
    {
        // ПРОВЕРКА ЕMAIL ПРИ ПОМОЩИ FILTER_VAR
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return ["error" => "Email не валиден"];
        }
        // ИЩЕМ ЮЗЕРА ПО НУЖНОМУ ID
        $checkUser = $this->userRepo->findByEmail($email);
        // ПРОВЕРКА ЮЗЕРА ПО EMAIL И СРАВНИВАЕМ ID ЮЗЕРА КОТОРОГО МЫ БУДЕТ ОБНОВЛЯТЬ
        if($checkUser && $checkUser->id !== $id){
            return ["error" => "Email taken man"];
        }
        try {
            // МОДЕЛЬ $userDto ДЛЯ ОБНОВЛЕНИЯ ПРОФИЛЯ
            $userDto = new UserDTO($id, $name, $email, '');
            //  ВЫЗОВ МЕТОДА update
            $this->userRepo->update($userDto);
            // ПОЛНОЦЕННОЕ ОБНОВЛЕНИЕ ПРОФИЛЯ
            return ["success" => "Profile updated", "user" => [
                "id" => $userDto->id,
                "name" => $userDto->name,
                "email" => $userDto->email,
            ]];
        }catch (\PDOException $e){
            return ["error" => "Update prifile Failed", $e->getMessage()];
        }
    }
}