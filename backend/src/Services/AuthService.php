<?php
    namespace App\Services;

    use App\Models\User;
    use App\Services\SessionService;

    class AuthService{
        // ФУНКЦИЯ ПРОВЕРКА РЕГИСТРАЦИИ 
        public function register(string $name,string $email,string $password):array 
        {
            // ПРОВЕРКА НА EMAIL
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return ['error' => 'Бро херня email не валиден'];
            }
            // ПРОВЕРКА ПАРОЛЯ 
            if(strlen($password) < 8){
                return ['error' => 'Бро пароль короткий'];
            }
            // ПРОВЕРКА ЮЗЕРА ЗАРЕГАН ОН
            $registered = User::findByEmail($email);
            if($registered){
                return ['error' => 'Ха ха юзера нет'];
            } 
            // хеширвоание пароля
            $hash = password_hash($password,PASSWORD_BCRYPT);
            User::create($name,$email,$hash);

            // ✅ Теперь всегда что-то вернёт
            return ["message" => "Бро все зарегался"];
        }
        // ФУНКИЦЯ ПРОВЕРКА ЛОГИНА 
        public function login(string $email, string $password):array{
            // ПРОВЕРКА ЮЗЕРА С ПАРЛЯМИ И ХЕШАМИ
            $user = User::findByEmail($email);
            if(!$user || !password_verify($password,$user['password'])){
                return ["error" => "Ну пароль и emaiL левый"];
            }
            // ГЕНКРАЦИЯ ТОКЕНА 
            $token = SessionService::generateToken();
            // СОХРАНЕНИЕ ТОКЕНА
            SessionService::create($token, $user['id']);
            // ВОЗРАЩЕНИЕ ТОКЕНА
            return ['token' => $token];
        }
        // ФУНКЦИЯ ПРОВЕРКА АТОРИЗАЦИИ
        public function checkAuth(){
            // получаем все загаловки вместе CONTENT-TYPE JSON HTTP 
            $headers = getallheaders();
            // ПРОВЕРК ЗАРЕГАН ЛИ ПОЛЬЗОВАТЕЛЬ ИЛИ НЕТ С ЭТИМ ЗАГОЛОВКОМ Authorization
            if(!isset($headers['Authorization'])) return null;
            $token = str_replace('Bearer ','',$headers['Authorization']);
            return SessionService::getUserById($token);
        }
        // ФУНКЦИЯ ОКОНЧАНИЕ СЕССИИ
        public function logout(string $token) {
            SessionService::revoke($token);
        }
    }
?>