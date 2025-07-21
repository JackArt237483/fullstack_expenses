<?php
    require __DIR__ . '/../vendor/autoload.php';

    use App\Routers\Router;
    use App\Controllers\ExpenseContrller;
    // заголовок в json
    header("Content-type: application/json");
    $router = new Router();
    $controller = new ExpenseContrller();
    // регистрация маршрутов
    $router->get('expenses', fn() =>$controller->index());
    $router->post('expenses', fn() => $controller->store());
    // получение путей
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>