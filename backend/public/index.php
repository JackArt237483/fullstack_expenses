<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Router\Router;
use App\Services\DataBase;
use App\Repositories\ExpenseRepository;
use App\Services\ExpenseServices;
use App\Controllers\ExpenseController;
use App\Controllers\CategoryController;
use App\Controllers\AuthController;

// Заголовки для JSON + CORS
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");

// Ответ на preflight-запрос (CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$pdo = DataBase::Connection();
$expenseRepository = new ExpenseRepository($pdo);
$expenseService = new ExpenseServices($expenseRepository);
$expenseController = new ExpenseController($expenseService);

// Роутер и контроллеры
$router = new Router();
$categoryController = new CategoryController();
$authController = new AuthController();

// Эндпоинты расходов
$router->get('/expenses', fn() => $expenseController->index());
//$router->get('/expenses/{id}', $expenseController->getById($user_id));
$router->post('/expenses', fn() => $expenseController->store());
$router->delete('/expenses/{id}/delete', fn($id) => $expenseController->delete($id));
$router->put('/expenses/{id}/', fn($id) => $expenseController->update($id));
$router->get('/categories', fn() => $categoryController->index());
// Эндпоинты маршрутов
$router->post('/auth/register', fn() => $authController->register());
$router->post('/auth/login', fn() => $authController->login());
$router->post('/auth/logout', fn() => $authController->logout());
$router->get('/auth/check', fn() => $authController->check());

// Определяем URI
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$uri  = '/' . ltrim(substr($path, strlen($base)), '/');

// Запускаем роутер
$router->dispatch($uri, $_SERVER['REQUEST_METHOD']);
