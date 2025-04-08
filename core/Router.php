<?php

class Router {
    private $routes = [];

    public function add($route, $controllerAction) {
        $this->routes[$route] = $controllerAction;
        //echo "Route added: $route -> $controllerAction\n";
    }

    public function dispatch($uri) {
        $uri = parse_url($uri, PHP_URL_PATH);
        //echo "Dispatching URI: $uri\n";

        if (array_key_exists($uri, $this->routes)) {
            [$controllerName, $method] = explode('@', $this->routes[$uri]);
            require_once "controllers/$controllerName.php";
            $controller = new $controllerName();
            $controller->$method();
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}

?>
