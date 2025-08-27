<?php
namespace App\Controllers;

use App\Models\Expense;

class ExpenseController{
    // get запрос
    public function index(){
        $expense = Expense::all();
        // получаем все записи
        echo json_encode($expense);
        // отправляем все записи в json
    }
    // post запрос
    public function store()
    {
        // штука которая полчаает из инпута данные
        $data = json_decode(file_get_contents("php://input"),true);

        if(!isset($data['title'],$data['amount'],$data['category_id'])
            || trim($data['title'] === "" ||
            (float) $data['amount'] <= 0)
        ){
            http_response_code(400);
            echo json_encode(['error' => 'error man']);
            return;
        }

        // метод создания записи
        $success = Expense::create($data['title'],(float)$data['amount'],(int)$data['category_id']);
        // ПРЕОБРАЗОВАНИЯ В JSON
        echo json_encode(['status' => $success ? 'success' : 'error']);
    }
    // delete запрос
    public function delete($id)
    {
        if(Expense::delete($id)){
            echo json_encode(['status' => 'success']);
        } else{
            http_response_code(404);
            echo json_encode(['error' => 'error man']);
        }
    }
    // put запрос
    public function update($id)
    {
        // метод получение данных из инпутов
        $data = json_decode(file_get_contents("php://input"),true);
        // валидация запроса проверка JSON
        if(!isset($data['title'],$data['amount'])){
            http_response_code(404);
            echo json_encode(['error' => 'just mistake man']);
            return;
        }
        $success = Expense::update($id,$data['title'],(float)$data['amount']);
        echo json_encode(['status' => $success ? 'success' : 'error']);
    }
}