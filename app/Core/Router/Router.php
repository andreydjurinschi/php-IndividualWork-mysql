<?php

namespace router;
require_once __DIR__ . "/HttpMethods.php";
require_once __DIR__ . "/../../../src/exceptions/routeNotFoundException.php";
use routeNotFoundException;

class Router
{
    private $routes = [];

    public function __construct(){

    }

    /***
     * Добавляет маршрут в массив маршрутов
     *
     * @param $method
     * @param $path
     * @param $action
     * @return void
     */
    public function addRoute($method, $path, $action){
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'action' => $action
        ];
    }

    /***
     * Направляет запрос на нужный метод исходя из пути и Http метода
     *
     * @param string $path
     * @return callable
     * @throws routeNotFoundException
     */
    public function dispatch($path){
        $method = $_SERVER['REQUEST_METHOD'];
        foreach($this->routes as $route){
            if($method === $route['method'] && $path === $route['path']){
                return call_user_func($route['action']);
            }
        }
        throw new RouteNotFoundException("Route not found", 404);
    }
}