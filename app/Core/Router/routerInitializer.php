<?php
require_once 'Router.php';
require_once __DIR__ . '/../Template/Template.php';
use router\Router;
use Template\Template;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router = new Router();

$template = new Template('layout', __DIR__ . '/../../Views');

$router->addRoute('GET', '/', function() use ($template){
    $template->render('mainPage', ['name' => 'HUI']);
});

try{
    $router->dispatch($path);
} catch (routeNotFoundException $e) {
    http_response_code(404);
    echo $e->getMessage();
}