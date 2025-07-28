<?php
namespace App\Models;

use App\Services\DataBase;
use PDO;

class Expense{
    // функция бля возрата всех рассходов с таблиц
    public static function all():array{
        $pdo = DataBase::Connection();
        // фильтрация по дате создвания
        $stmt = $pdo->query('
        SELECT expenses .*, categories.text AS category_text
        FROM expenses
        LEFT Join categiries On exopenses.category_id = categories.id
        ORDER BY created_at DESC');
        // возрат всех трат
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // функция для создания расходов в таблице
    public static function create(string $title,float $amount,int $category_id):bool
    {
        $pdo = DataBase::Connection();
        $stmt = $pdo->prepare('INSERT INTO expenses (title,amount,category_id) VALUES(:title,:amount,:category_id)');
        return $stmt->execute([
            ':title' => $title,
            ':amount' => $amount,
            ':category_id' => $category_id
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