<?php
    require __DIR__ . '/../vendor/autoload.php';

    use App\Router\Router;
    use App\Controllers\ExpenseController;
    // заголовок в json
    header("Content-type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
    // подрубаем классы
    $router = new Router();
    $controller = new ExpenseController();
    // регистрация маршрутов
    $router->get('/expenses', fn() =>$controller->index());
    $router->post('/expenses', fn() => $controller->store());
    // получение путей и разбивка из на части без параметров
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $router->dispatch($uri, $method);

?>