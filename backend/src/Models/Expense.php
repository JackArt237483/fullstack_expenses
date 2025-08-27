<?php
namespace App\Models;

use App\Services\DataBase;
use PDO;

// ОДНА МОДЕЛЬ КОТОРАЯ НИЧЕГО НЕ ДЕЛАЕТ ПРОСТО СУЩЕСТВУЕТ
class Expense{
    public function __construct(
        public int $id,
        public string $title,
        public float $amount,
        public int $category_id,
        public int $user_id,
        public string $created_at
    ){}
}