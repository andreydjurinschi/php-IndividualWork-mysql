<?php
require_once 'Router.php';
use router\Router;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router = new Router();

$router->addRoute('GET', '/', function() {
    echo "Hello, World!";
});

try{
    $router->dispatch($path);
} catch (routeNotFoundException $e) {
    http_response_code(404);
    echo $e->getMessage();
}