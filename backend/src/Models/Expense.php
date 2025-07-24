<?php
namespace App\Models;

use App\Services\DataBase;

class Expense{
    // функция бля возрата всех рассходов с таблиц
    public static function all():array{
        $pdo = DataBase::Connection();
        // фильтрация по дате создвания
        $stmt = $pdo->query('SELECT * FROM expenses ORDER BY created_at DESC');
        // возрат всех трат
        return $stmt->fetchAll();
    }
    // функция для создания расходов в таблице
    public static function create(string $title,float $amount):bool
    {
        $pdo = DataBase::Connection();
        $stmt = $pdo->prepare('INSERT INTO expenses (title,amount) VALUES(:title,:amount)');
        return $stmt->execute([
            ':title' => $title,
            ':amount' => $amount
        ]);
    }

}