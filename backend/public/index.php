<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Router\Router;
use App\Controllers\ExpenseController;
use App\Controllers\CategoryController;

// Заголовки для JSON + CORS
header("Content-type: application/json");
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
$prefix = '/train_skills/backend/public';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$uri = str_replace($prefix, '', $uri);

