<?php
    namespace App\Services;

    use App\DTO\UserDTO;
    use App\Repositories\UserRepository;
    use App\Repositories\SessionRepository;

    class AuthService{
        private UserRepository $userRepo;
        private SessionRepository $sessionRepo;
        // СОЗДАТЬ DI ЧТОБЫ ВРУЧНУЮ ВСЕ НЕ СОЗАДВАТЬ
        public function __construct(UserRepository $userRepo, SessionRepository $sessionRepo)
        {
            $this->userRepo = $userRepo;
            $this->sessionRepo = $sessionRepo;
        }
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
            if($this->userRepo->findByEmail($email)){
                return ['error' => 'Бро юзер с таким именем уже существует'];
            }
            try {
                // хеширвоание пароля
                $hash = password_hash($password,PASSWORD_BCRYPT);
                $userDTO = new UserDTO($name,$email,$hash);
                $this->userRepo->create($userDTO);
                // ✅ Теперь всегда что-то вернёт
                return ["message" => "Бро все зарегался"];
            } catch (\PDOException $e){
                return ['error' => "Ошибка регситрации", $e->getMessage()];
            }
        }
        // ФУНКИЦЯ ПРОВЕРКА ЛОГИНА 
        public function login(string $email, string $password):array{
            try {
                // ПРОВЕРКА ЮЗЕРА С ПАРЛЯМИ И ХЕШАМИ
                $user = $this->userRepo::findByEmail($email);
                if(!$user || !password_verify($password,$user['password'])){
                    return ["error" => "Ну пароль и email левый и некоректны"];
                }
                // ГЕНКРАЦИЯ ТОКЕНА
                $token = $this->sessionRepo::generateToken();
                // СОХРАНЕНИЕ ТОКЕНА
                $this->sessionRepo::create($token, $user->id);
                // ВОЗРАЩЕНИЕ ТОКЕНА
                return ['token' => $token];
            } catch (\PDOException $e){
                return ['error' => 'Ошибка при создании токена', $e->getMessage()];
            }
        }
        // ФУНКЦИЯ ПРОВЕРКА АТОРИЗАЦИИ
        public function checkAuth(){
            // получаем все загаловки вместе CONTENT-TYPE JSON HTTP 
            $headers = getallheaders();
            // ПРОВЕРК ЗАРЕГАН ЛИ ПОЛЬЗОВАТЕЛЬ ИЛИ НЕТ С ЭТИМ ЗАГОЛОВКОМ Authorization
            if(!isset($headers['Authorization'])) return null;
            $token = str_replace('Bearer ','',$headers['Authorization']);
            return $this->sessionRepo::getUserByIdToken($token);
        }
        // ФУНКЦИЯ ОКОНЧАНИЕ СЕССИИ
        public function logout(string $token) {
            $this->sessionRepo::revoke($token);
        }
    }
?>