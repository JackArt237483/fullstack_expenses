<?php
namespace App\Interfaces;
use App\DTO\UserDTO;

// интрейфес дял user
interface UserInterface{
    // Метод для поиска user по email
    public function findByEmail(string $email): ?UserDTO;
    // Метод для созадния user
    public function create(UserDTO $user):bool;
    public function update(UserDTO $user):bool;
}