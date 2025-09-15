<?php
// DI контейнер для управлениеям зависимостями
use App\Interfaces\SessionInterface;
use App\Interfaces\UserInterface;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Dotenv\Dotenv;
use Di\Container;
use App\Services\DataBase;
// создается точка входа дял загрузки переменных
$dontenv = Dotenv::createImmutable(__DIR__);
// загружаем все необходимые переменные с .ENV файла
$dontenv->load();
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
$container->set(PDO::class, function () use ($dbConfig){
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
// Регистрируется сервис ProfileService, который отвечает за логику аутентификации.

