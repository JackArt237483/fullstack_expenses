<?php
    // КЛАСС ДЛЯ РОУТЕРОВ РЕГИСТРАЦИИ
    namespace App\Controllers;

    use App\Core\Response;
    use App\Services\AuthService;

    class AuthController{
        private AuthService $auth;
        // ЮЗАЕМ МЕТОДЫ ИЗ AuthService
        public function __construct(AuthService $auth){
            $this->auth = $auth;
        }
        // обработка HTTP запросов регистрации
        public function register() {
            $data = json_decode(file_get_contents('php://input'),true);
            $res = $this->auth->register($data['name'],$data['email'],$data['password']);
            Response::json($res,isset($res['error']) ? 400 : 201);
        }
        // обработка HTTP запросов логина 
        public function login() {
            $data = json_decode(file_get_contents('php://input'),true);
            $res = $this->auth->login($data['email'],$data['password']);
            Response::json($res, isset($res['error']) ? 400 : 201 );      
        }
        // проверка сессии в базе
        public function check(){
            $userId = $this->auth->checkAuth();
            // ТО ЕСТЬ ЕСЛИ ОШИБКА И НЕТУ ЮЗЕРА В БД 400 ERROR
            if(!$userId) return Response::json(['error' => 'Ошибка бро авторизации'],400);
            // ЕСЛИ ЕСТЬ ТО ВОЗРАТ ID ЮЗЕРА
            Response::json(['user_id' => $userId]);
        }
        // функция для выхода 
        public function logout(){
            // ПОЛУЧЕНИЕ HTTP ЗАГАЛОВКА 
            $headers = getallheaders();
            $token =  str_replace("Bearer ", "",$headers['Authorization']);
            // Удаление сессии по токену
            $this->auth->logout($token);
            Response::json(['message' => 'Выход выполнен']);
        }
    }
?>