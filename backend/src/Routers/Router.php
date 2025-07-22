<?php
    namespace App\Routers;
class Router {
    // массив для хранения путей
    private array $routes = [];
    public function get(string $path, callable $callback)
    {
        $this->AddRoute('GET', $path, $callback);
    }
    public function post(string $path, callable $callback){
        $this->AddRoute('POST', $path, $callback);
    }
    // функция дял путей
    private function AddRoute( string $method, string $path, callable $callback)
    {
        $this->routes[$method][$path] = $callback;
    }
    public function dispatch(string $uri, string $method)
    {
        $uri =  rtrim($uri, '/');
        // проверка а есть ли вообще маршрут
        $callback = $this->routes[$method][$uri] ?? null;
        // проверка на путь
        if(!$callback){
            http_response_code(400);
            echo json_encode(['error' => 'Not right route']);
            return;
        }
        call_user_func($callback);
    }


}