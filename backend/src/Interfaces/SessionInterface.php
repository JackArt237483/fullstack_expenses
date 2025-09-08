<?php
namespace App\Interfaces;

interface SessionInterface
{
    public function generateToken();
    public function create(string $token,int $user_id);
    public function getUserByIdToken($token): ?int;
    public function revoke(string $token);
}
