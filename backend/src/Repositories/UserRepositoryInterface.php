<?php
namespace App\Repositories;
use App\DTO\UserDTO;
// интрейфес дял user
interface UserRepositoryInterface{
    // Метод для поиска user по email
    public function findByEmail(string $email): ?UserDTO;
    // Метод для созадния user
    public function create(UserDTO $user):bool;
}