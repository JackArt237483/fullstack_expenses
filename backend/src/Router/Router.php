<?php
    namespace App\Router;
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
        public function put(string $path, callable $callback){
            $this->AddRoute('PUT', $path, $callback);
        }
        public function delete(string $path, callable $callback)
        {
            $this->AddRoute('DELETE', $path, $callback);
        }
        // функция дял путей
        private function AddRoute( string $method, string $path, callable $callback)
        {
            $path = rtrim($path, '/');
            $this->routes[$method][] = [
                "pattern" => preg_replace('#\{(\w+)\}#','(?P<id>[^/]+)',$path),
                "callback" => $callback
            ];
        }
        public function dispatch(string $uri, string $method)
        {
            $uri =  rtrim($uri, '/');
            // проверка а есть ли вообще маршрут
            $routes = $this->routes[$method] ?? [];
            // перебор всех путей через цикл
            foreach($routes as $route) {
                // проверка на URI c помощью регулярок
                $pattern = "#^". $route["pattern"]."$#";
                // проверка на совпвадение маршрутов с патерном 
                if(preg_match($pattern,$uri,$matches)){
                    // ФИЛЬТР МАССИВА ТАК ЧТОБЫ ОСТАЛИСЬ НУЖНЫЕ ДАННЫЕ
                    $params = array_filter($matches,'is_string',ARRAY_FILTER_USE_KEY);
                    call_user_func_array($route['callback'],$params);
                    return;
                }
            }
        
            
            http_response_code(404);
            echo json_encode(['error' => 'Not right route']);

        }
        
    }