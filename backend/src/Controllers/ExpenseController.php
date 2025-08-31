<?php
namespace App\Controllers;

use App\Services\ExpenseServices;
class ExpenseController{
    public function __construct(private ExpenseServices $services){}
    // Обрабатывает GET-запрос для получения всех расходов
    public function index(){
        $expense = $this->services->getAllExpense();
        // получаем все записи
        echo $this->json($expense);
        // отправляем все записи в json
    }
    // Обрабатывает GET-запрос получения расходов конкретного пользовател
    public function getById(int $user_id){
        $expense = $this->services->getExpenseById($user_id);
        if(empty($expense)){
            $this->json(['error' => 'У юзера нет расходов'], 404);
            return;
        }

        $this->json($expense);
    }
    // Обрабатывает POST-запрос для создания нового расхода.
    public function store()
    {
        $data = $this->jsonInput();

        $result = $this->services->createExpense($data);

        if(!$result){
            $this->json(['error' => 'Неврзможно моздать расход'],404);
            return;
        }

        $this->json(['status' => 'created'],200);
    }
    // Обрабатывает Delete-0 запрос для удаление расхода
    public function delete($id)
    {
        $result = $this->services->deleteExpense($id);

        if(!$result){
            $this->json(['error' => 'Не удалить расход по id']);
            return;
        }

        $this->json(['status' => 'deleted'],);
    }
    // Обрабатывает PUT-запрос для обновления существующего расхода.
    public function update($id)
    {
        // метод получение данных из инпутов
        $data = $data = $this->jsonInput();
        // валидация запроса проверка JSON
        $result = $this->services->updateExpense($id,$data);
        if(!$result){
            $this->json(['error' => 'Неврзможно оновить расход'],404);
            return;
        }

        $this->json(['status' => 'updated']);
    }
    // Получае JSON-данные из тела HTTP-ЗАПРОСА
    private function jsonInput()
    {
        // штука которая полчаает из инпута данные
        $input = file_get_contents("php://input");
        return json_decode($input,true) ?? [];
    }
    // Универсальный метод для отправки JSON-ответов клиенту.
    private function json(array $data, int $code = 200){
        http_response_code($code);
        header("Content-Type: application/json");
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
}