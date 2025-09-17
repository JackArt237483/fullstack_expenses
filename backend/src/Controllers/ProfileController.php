<?php
namespace App\Controllers;
// Метод для обработки запросов в профиле юзера
use App\Core\Response;
use App\Services\AuthService;
use App\Services\ProfileService;

class ProfileController{
    // service для прроверки авторизации
    private AuthService $authService;
    // service для проверки профиля
    private ProfileService $profileService;
    public function __construct(AuthService $authService, ProfileService $profileService)
    {
        $this->authService = $authService;
        $this->profileService = $profileService;
    }
    // ВСПОМОГАТЕЛЬНЫЙ МЕТОД ДЛЯ HTTP ЗАПРОСА
    public function getData(): array {
        // ДАННЫЕ С ИНПУТА В ЛИЧНОМ КАБИНЕ С ФРОНТА
        $data = file_get_contents("php://input");
        // ВОЗРАЩАЕТ МАССИВ С ФРОНТА
        return json_decode($data,true) ?? [];
    }
    // обновление авторизации
    public function update(){
        // проверка токена сесии юзера
        $userId = $this->authService->checkAuth();
        // ПРОВЕРКА ЮЗЕРА НА NULL FALSE АВТОРИЗИРОВАН И ТД
        if(!$userId){
            // И ЕСЛИ УСЛОВИЕ СОВПАДАЕТ ТО ВОЗРАЩАЕТ ВОТ ТАКОЕ УСЛОВИЕ
            Response::json(["error" => "Bro not autorized"], 401, );
        }
        // ПРОВЕРКА НА ПУСТЫЕ ПОЛЯ С ФРОНТА
        $data = $this->getData();
        // ПРОЫЕРКА ПРИ ПОМОЩИ EMPTY
        if(empty($data["name"]) || empty($data["email"])){
            return Response::json(["error" => "email and name is empty"],401);
        }
        // ВЫЗОВ МЕТОДА UPDATEPROFILE
        $res = $this->profileService->updateProfile($userId, $data["name"], $data["email"]);
        // И ВОЗРОЩАЕМ ПОЛУЧАЕТСЯ МЕТОД ИЛИ 401 И 200
        Response::json($res, isset($res['error']) ? 401 : 200);
    }
}