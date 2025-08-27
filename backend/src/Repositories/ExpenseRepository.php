<?php
 namespace App\Repositories;

 use App\Models\Expense;
 use PDO;
 use PDOException;

 // РЕПОЗИТРОРИЙ ДЛЯ РАБОТЫ С БАЗОЙ ДАННЫХ
class ExpenseRepository{
    // копия обьекта PDO
    public function __construct(private PDO $pdo){}
    // получение всех записей с финансами
    public function getAll():array{
        try {
            $stmt = $this->pdo->query('
                SELECT expenses .*, categories.text AS category_text
                FROM expenses
                LEFT Join categories On expenses.category_id = categories.id
                ORDER BY created_at DESC');
            // возрат всех трат в виде массива
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // создание копиии Expense с готовцыми данными
            return array_map(fn($row) => $this->mapToModal($row), $rows);
        }catch (PDOException $e){
            error_log($e->getMessage());
            return [];
        }
    }
    public function getUserById(int $user_id):array{
        try {
            $stmt = $this->pdo->query('
                SELECT expenses .*, categories.text AS category_text
                FROM expenses
                LEFT Join categories On expenses.category_id = categories.id
                WHERE expenses.user_id = :id
                ORDER BY created_at DESC');
            $stmt->execute(['user_id' => $user_id]);
            // возрат всех трат в виде массива
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // создание копиии Expense с готовцыми данными
            return array_map(fn($row) => $this->mapToModal($row), $rows);
        }catch (PDOException $e){
            error_log($e->getMessage());
            return [];
        }
    }
    // функция для создания расходов в таблице
    public function create(string $title,float $amount,int $category_id,int $user_id):bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO expenses (title,amount,category_id,user_id) VALUES(:title,:amount,:category_id,:user_id)');
        return $stmt->execute([
            ':title' => $title,
            ':amount' => $amount,
            ':user_id' => $user_id,
            ':category_id' => $category_id
        ]);
    }
    // функция удаления расходов из таблицы
    public function delete(int $id):bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM expenses WHERE id = :id');
        return $stmt->execute([
            ':id' => $id
        ]);
    }
    // функция обновления расходов из таблицы
    public function update(int $id,string $title, float $amount)
    {
        $stmt = $this->pdo->prepare("UPDATE expenses SET title = :title,amount = :amount WHERE id = :id");
        $stmt->execute([
            "id" => $id,
            "title" => $title,
            "amount" => $amount
        ]);
    }
    // функция копия обьекта Expense c данными из таблицы
    private function mapToModal(array $row):Expense
    {
        // копия готовго массива row с данными таблиы
        return new Expense(
            id: (int)$row['id'],
            title: $row['title'],
            amount:(float)$row['amount'],
            category_id: (int)$row['category_id'],
            user_id: (int)$row['user_id'],
            created_at: $row['created_at']
        );
    }
}