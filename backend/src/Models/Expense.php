<?php
namespace App\Models;

use App\Services\DataBase;
use PDO;

class Expense{
    // функция бля возрата всех рассходов с таблиц
    public static function all():array{
        $pdo = DataBase::Connection();
        // фильтрация по дате создвания
        $stmt = $pdo->query('SELECT * FROM expenses ORDER BY created_at DESC');
        // возрат всех трат
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    // функция удаления расходов из таблицы
    public static function delete(int $id):bool
    {
        $pdo = DataBase::Connection();
        $stmt = $pdo->prepare('DELETE FROM expenses WHERE id = :id');
        return $stmt->execute([
            ':id' => $id
        ]);
    }
    // функция обновления расходов из таблицы
    public static function update(int $id,string $title, float $amount) 
    {
        $pdo = DataBase::Connection();
        $stmt = $pdo->prepare("UPDATE expenses SET title = :title,amount = :amount WHERE id = :id");
        $stmt->execute([
            "id" => $id,
            "title" => $title,
            "amount" => $amount
        ]);
    }
}