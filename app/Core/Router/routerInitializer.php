<?php
require_once 'Router.php';
require_once __DIR__ . '/../Template/Template.php';
require_once __DIR__ . '/../../../app/Controllers/AuthenticationController.php';

use Controllers\AuthenticationController;
use router\Router;
use Template\Template;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router = new Router();

$template = new Template('layout/layout', __DIR__ . '/../../Views');

$router->addRoute('GET', '/login', function() use ($template){
    $template->render('loginView', ['title' => 'Login']);
});
$router->addRoute('GET', '/logout', function(){
    $authController = new AuthenticationController();
    $authController->logout();
    header("Location: /login");
});

$router->addRoute('POST', '/login', function() use ($template) {
    $authController = new AuthenticationController();
    $authController->login();
});

$router->addRoute('GET', '/', function() use ($template){
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
    $template->render('mainView', ['title' => 'Main Page']);
});

try{
    $router->dispatch($path);
} catch (routeNotFoundException $e) {
    $template->render('errorView', ['error' => 'route not found']);
}