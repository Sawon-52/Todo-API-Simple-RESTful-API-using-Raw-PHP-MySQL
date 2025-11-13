<?php
namespace App\Core;

class Router {
    protected $routes = [];
    protected $db; // Database instance

    public function setDatabase(Database $db) {
        // $this->db = $db;
    }

    public function get($uri, $action) { $this->add('GET', $uri, $action); }
    public function post($uri, $action) { $this->add('POST', $uri, $action); }

    protected function add($method, $uri, $action) {
        $this->routes[$method][trim($uri, '/')] = $action;

        // echo "<pre>";
        // print_r($this->routes);
        // die();
    }

    public function dispatch() {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        $action = $this->routes[$method][$uri] ?? null;

        if ($action) {
            $this->callAction($action);
        } else {
            Response::json(['error' => '404 Not Found'], 404);
        }
    }

    protected function callAction($action) {
        [$controller, $method] = explode('@', $action);
        // echo $controller . $method ; die;
        $controllerClass = 'App\\Controllers\\' . $controller;

        if (!class_exists($controllerClass)) {
             Response::json(['error' => 'Controller Not Found'], 500); return;
        }

        $controllerInstance = new $controllerClass($this->db);

        // Controller Method কল করা
        $result = $controllerInstance->$method(new Request()); 
        
        // বেস্ট প্র্যাকটিস: Controller থেকে ফেরত আসা ডেটা নিয়ে Response পাঠানো
        $statusCode = $result['status_code'] ?? 500;
        $data = $result['data'] ?? ['error' => 'Internal Server Error'];
        
        Response::json($data, $statusCode);
    }
}