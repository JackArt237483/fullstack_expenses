<?php
// Настройка DI контейнер для управлениеям зависимостями
use App\Controllers\AuthController;
use App\Controllers\ProfileController;
use App\Interfaces\SessionInterface;
use App\Interfaces\UserInterface;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\ProfileService;
use Dotenv\Dotenv;
use Di\Container;
use App\Services\DataBase;
// создается точка входа дял загрузки переменных
$dotenv = Dotenv::createImmutable(__DIR__);
// загружаем все необходимые переменные с .ENV файла
$dotenv->load();
// конфиг дял подключения
$dbConfig = [
    'host' => $_ENV['DB_HOST'] ?? '',
    'port' => $_ENV['DB_PORT'] ?? '',
    'dbname' => $_ENV['DB_NAME'] ?? '',
    'user' => $_ENV['DB_USER'] ?? '',
    'password' => $_ENV['DB_PASS'] ?? '',
];
//Импорт контрейнера
$container = new Container();
//ОДИН PDO ДЛЯ ВСЕХ ТО ЕСТЬ ЕСЛИ НУЖНО БУДЕТ ВОЗЬМИ ОТСЮДА
$container->set(PDO::class, function () use ($config){
    return (new DataBase())->Connection($dbConfig);
});
// МЕТОДЫ С РЕАЛИЗАЦИЕЙ ИНТРЕЙФЕСОВ И РЕПОЗИТОРИЯ
$container->set(UserInterface::class, fn($c) => new UserRepository($c->get(PDO::class)));
$container->set(SessionInterface::class, fn($c) => new SessionRepository($c->get(PDO::class)));
// Регистрируется сервис AuthService, который отвечает за логику аутентификации.
$container->set(AuthService::class, fn($c) => new AuthService(
    $c->get(UserInterface::class),
    $c->get(SessionInterface::class)
));
// Регистрируется сервис ProfileService, который отвечает за логику апдейта профиля.
$container->set(ProfileService::class, fn($c) => new ProfileService(
    $c->get(UserInterface::class),
));
// РЕГИСТРАЦИЯ AuthController КОНТРОЛЕРА ДЛЯ DI КОНТЕЙНЕР
$container->set(AuthController::class, fn($c) => new AuthController(
  $c->get(AuthService::class)
));
// РЕГИСТРАЦИЯ КОНТРОЛЕРОВ ДЛЯ DI КОНТЕЙНЕР
$container->set(ProfileController::class, fn($c) => new ProfileController(
    $c->get(ProfileService::class),
    $c->get(AuthService::class)
));

return $container;

