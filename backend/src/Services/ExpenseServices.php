<?php
 namespace App\Services;

 use App\Repositories\ExpenseRepository;

 class ExpenseServices{
    public function __construct(private ExpenseRepository $repo){}
    // Метод возрощает записи все из репозитория
     public function getAllExpense():array
     {
         return $this->repo->getAll();
     }
     //  Метод получение записей по id юзера
     public function getExpenseById(int $user_id):array
     {
         // проверка то что id больше 0
        if($user_id <= 0) return [];
        // если id валиден то вызывается метод
        return $this->repo->getUserById($user_id);
     }
     //  Метод Создает новый расход
     public function createExpense(array $data):bool{
          if(
              empty(
            (string)$data['title'] ||
            (float)$data['amount'] <= 0 ||
            (int)$data['category_id'] <= 0 ||
            (int)$data['user_id'] <= 0)
          )
        {
            return false;
        }
          return $this->repo->create(
              (string)$data['title'],
              (float)$data['amount'],
              (int)$data['category_id'],
              (int)$data['user_id']
          );
     }
     // Метод обновлет существующий расход
     public function updateExpense(int $id, array $data):bool
     {
        if(
            $id <= 0 ||
            empty($data['title']) ||
            (float)$data['amount'] <= 0)
        {
            return false;
        }
        return $this->repo->update($id, $data['title'], (float)$data['amount']);
     }
     // Метод удаляет существующий расход по id.
    public function deleteExpense(int $id):bool {
        if($id <= 0) return false;
        return $this->repo->delete($id);
    }
 }