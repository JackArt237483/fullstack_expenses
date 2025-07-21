<?php
namespace App\Controllers;

use App\Services\Expense;

class ExpenseContrller{
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
        if(!isset($data['title'],$data['amount'])){
            http_response_code(400);
            echo json_encode(['error' => 'error man']);
            return;
        }
        // метод создания записи
        $success = Expense::create($data['title'],(float)$data['amount']);
        // ПРЕОБРАЗОВАНИЯ В JSON
        echo json_encode(['status' => $success ? 'success' : 'error']);
    }
}