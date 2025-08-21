<?php
namespace App\Controllers;

use App\Models\Expense;
use App\Services\SessionService;

class ExpenseController{
    // get запрос
    public function index(){
        // перехват запроса с фронта
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        if(!$token){
            http_response_code(401);
            echo json_encode(['error' => 'ha ha user not here']);
            return;
        }
        // полчуение id юзера
        $user_id = SessionService::getUserById($token);
        if(!$user_id){
            http_response_code(401);
            echo json_encode(['error' => 'ha ha user not here']);
            return;
        }
        $expense = Expense::all($user_id);
        // получаем все записи
        echo json_encode($expense);
        // отправляем все записи в json
    }
    // post запрос
    public function store()
    {
        //полчам данные из инпута
        $data = json_decode(file_get_contents("php://input"),true);
        // поподания запроса с ронта
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        $user_id = SessionService::getUserById($token);

        if($user_id){
            http_response_code(400);
            echo json_encode(['error' => 'ha ha user not here']);
            return;
        }


        if(!isset($data['title'],$data['amount'],$data['category_id'])
            || trim($data['title'] === "" || 
            (float) $data['amount'] <= 0)
        ){
            http_response_code(400);
            echo json_encode(['error' => 'error man']);
            return;
        } 

        // метод создания записи
        $success = Expense::create(
            $data['title'],
            (float)$data['amount'],
            (int)$data['category_id'],
            $user_id
        );
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