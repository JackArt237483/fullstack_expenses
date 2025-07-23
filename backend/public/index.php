<?php
    require __DIR__ . '/../vendor/autoload.php';

    use App\Router\Router;
    use App\Controllers\ExpenseController;
    // заголовок в json
    header("Content-type: application/json");
    $router = new Router();
    $controller = new ExpenseController();
    // регистрация маршрутов
    $router->get('/expenses', fn() =>$controller->index());
    $router->post('/expenses', fn() => $controller->store());
    // получение путей и разбивка из на части без параметров
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // получение метода запроса HTTP-запроса
    $method = $_SERVER['REQUEST_METHOD'];
    $router->dispatch($uri, $method);
?>