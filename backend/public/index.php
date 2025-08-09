<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Router\Router;
use App\Controllers\ExpenseController;
use App\Controllers\CategoryController;

// Заголовки для JSON + CORS
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");

// Ответ на preflight-запрос
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Роутер и контроллер
$router = new Router();
$controller = new ExpenseController();
$categoryController = new CategoryController();


// Маршруты
$router->get('/expenses', fn() => $controller->index());
$router->post('/expenses', fn() => $controller->store());
$router->delete('/expenses/{id}/delete', fn($id) => $controller->delete($id));
$router->put('/expenses/{id}/update', fn($id) => $controller->update($id));
$router->get('/categories', fn() => $categoryController->index());

// Обработка запроса
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$base = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'])), '/'); // напр. "" или "/subdir"
$uri  = '/' . ltrim(substr($path, strlen($base)), '/'); // получится "/expenses" и т.п.

// далее матчишь $uri в роутере
