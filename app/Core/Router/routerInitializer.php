<?php

/**
 * Инициализирует маршруты приложения и обрабатывает входящие HTTP-запросы.
 */

require_once 'Router.php';
require_once __DIR__ . '/../Template/Template.php';
require_once __DIR__ . '/../../../app/Controllers/AuthenticationController.php';
require_once __DIR__ . '/../../../app/Controllers/RegisterController.php';
require_once __DIR__ . '/../../../app/Controllers/User/UserController.php';
require_once __DIR__ . '/../../Controllers/Post/PostController.php';
require_once __DIR__ . '/../../../src/handlers/UserFormHandler.php';
require_once __DIR__ . '/../../../src/handlers/PostHandler.php';

use Controllers\AuthenticationController;
use Controllers\RegisterController;
use Controllers\User\UserController;
use Controllers\Post\PostController;
use handlers\PostHandler;
use handlers\UserFormHandler;
use router\Router;
use Services\UserService;
use Template\Template;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router = new Router();

$template = new Template('layout/layout', __DIR__ . '/../../Views');


//              --- Маршруты для входа в систему ---
$router->addRoute('GET', '/login', function() use ($template){
    $template->render('AccountViews/loginView', ['title' => 'Login']);
});

$router->addRoute('POST', '/login', function() use ($template) {
    $authController = new AuthenticationController();
    $authController->login();
});

$router->addRoute('GET', '/logout', function(){
    $authController = new AuthenticationController();
    $authController->logout();
    header("Location: /login");
});

$router->addRoute('GET', '/register', function() use ($template){
    $template->render('AccountViews/registerView', [
        'title' => 'Register'
    ]);
});
//              --- Маршруты для регистрации ---
$router->addRoute('POST', '/register', function() use ($template) {
    $controller = new RegisterController();
    if(is_string($controller->register())){
        $template->render('AccountViews/registerView', [
            'title' => 'Register',
            'error' => $_SESSION['error']
        ]);
    }
    else{
        header('Location: /login');
        exit();
    }
});

//             --- Маршруты для работы с пользователями ---

$router->addRoute(GET, '/allUsers', function() use ($template){
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }

    if ($_SESSION['role_id'] != 1) {
        $template->render('errorView', ['error' => 'Access denied']);
        exit();
    }
    $userController = new UserController();
    $allUsers = $userController->getAllUsers();
    $template->render('UsersViews/users-index', [
        'title' => 'All Users',
        'users' => $allUsers
    ]);
});

$router->addRoute('GET', '/user/view', function() use ($template){
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
    $userId = $_GET['user_id'] ?? null;

    if ($userId) {
        require_once __DIR__ . '/../../Services/UserService.php';
        $userService = new UserService();

        $user = $userService->getById((int)$userId);
        if (!$user) {
            $template->render('errorView', ['error' => 'user not found']);
            exit();
        }

        $template->render('AccountViews/edit-user', [
            'title' => 'Edit User',
            'user' => $user
        ]);
    }
});

$router->addRoute('GET', '/user/info', function() use ($template){
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
    $userId = $_GET['user_id'] ?? null;

    if ($userId) {
        require_once __DIR__ . '/../../Services/UserService.php';
        $userService = new UserService();

        $user = $userService->getById((int)$userId);
        if (!$user) {
            $template->render('errorView', ['error' => 'user not found']);
            exit();
        }

        $template->render('AccountViews/info-user', [
            'title' => 'Edit User',
            'user' => $user
        ]);
    }
});

$router->addRoute('POST', '/user/update', function() use ($template){
    $handler = new UserFormHandler();
    $result = $handler->handleUpdate();

    if (is_string($result)) {
        $template->render('AccountViews/edit-user', [
            'title' => 'Edit User',
            'error' => 'Error updating user: ' . $result
        ]);
        exit();
    }
    header('Location: /');
    exit();
});




//             --- Маршруты для главной страницы ---
$router->addRoute('GET', '/', function() use ($template){
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
    $template->render('mainView', ['title' => 'Main Page']);
});


//             --- Маршруты для постов ---

$router->addRoute('GET', '/post/update', function() use ($template){
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
    $postController = new PostController();
    $post = $postController->getPost((int)$_GET['id']);
    if($post['user_id'] != $_SESSION['user_id'] && $_SESSION['role_id'] != 1){
        $template->render('errorView', ['error' => 'Access denied']);
        exit();
    }
    if (!$post) {
        $template->render('errorView', ['error' => 'Post not found']);
        exit();
    }
    $template->render('PostsViews/edit-post', ['title' => 'Posts', 'post' => $post]);
});
$router->addRoute('POST', '/post/update', function() use ($template){
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
    $postController = new PostController();
    $post = $postController->getPost((int)$_GET['id']);
    $id = $post['id'];
    if (!$post) {
        $template->render('errorView', ['error' => 'Post not found']);
        exit();
    }
    $postHandler = new PostHandler();
    $result = $postHandler->handleUpdatePost($id);
    if (is_string($result)) {
        $template->render('PostsViews/edit-post', [
            'title' => 'Edit Post',
            'error' => 'Error updating post: ' . $result,
            'post' => $post
        ]);
        exit();
    }
    header('Location: /allPosts');
});

$router->addRoute('GET', '/allPosts', function() use ($template) {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
    $postController = new PostController();
    $posts = $postController->getAllPosts();
    $template->render('PostsViews/posts-index', ['title' => 'All Posts', 'posts' => $posts]);
});

$router->addRoute('GET', '/post/create', function() use ($template){
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
    $template->render('PostsViews/create-post', ['title' => 'Create Post']);
});

$router->addRoute('POST', '/post/create', function() use ($template){
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
    $handler = new PostHandler();
    $result = $handler->handleCreatePost();

    if (is_string($result)) {
        $template->render('PostsViews/create-post', [
            'title' => 'Create Post',
            'error' => 'Error creating post: ' . $result
        ]);
        exit();
    }
    header('Location: /allPosts');
    exit();
});

$router->addRoute('GET', '/post/view', function() use ($template) {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }

    $postId = $_GET['id'] ?? null;

    if ($postId) {
        require_once __DIR__ . '/../../Services/PostService.php';
        $postController = new PostController();
        $userController = new UserController();
        $post = $postController->getPost($postId);
        $user = $userController->getUser($post['user_id']);
        if (!$post) {
            $template->render('errorView', ['error' => 'Post not found']);
            exit();
        }
        $template->render('PostsViews/view-post', [
            'title' => 'View Post',
            'post' => $post,
            'user' => $user
        ]);
    }
});




//             --- Направление запроса ---
try{

    $router->dispatch($path);
} catch (routeNotFoundException $e) {
    $template->render('errorView', ['error' => 'route not found']);
}