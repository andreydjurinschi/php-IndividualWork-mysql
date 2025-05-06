## Индивидуальная работа по `PHP`
### Студенческий портал `StudNet`
#### Выполнил: Студент группы I2302 Djurinschi Andrei

### Веб приложение `StudNet`
#### Является студенческим порталом, предоставляющим доступ к новостям и полезным ресурсам для студентов.

### Для реализации проекта использовались следующие технологии:
- `PHP` - язык программирования для серверной части приложения.
- `HTML` - язык разметки для создания структуры веб-страниц.
- `Bootstrap` - CSS-фреймворк для создания адаптивного дизайна.
- `MySQL` - система управления базами данных для хранения информации о пользователях и новостях.
- `Docker` - для контейнеризации приложения и обеспечения его работоспособности в различных средах.
- `Git` - система контроля версий для управления кодом.

### Структура проекта
```
app/
├── Controllers/
|  ├── Post/
|       ├──PostController.php
|       ├──TagController.php      
|  ├── User/
|        ├──UserController.php
|  ├── AutentificationController.php
|  ├── RegistrationController.php
|
├──Core
|    ├──Router
|    |    ├──HttpMethods.php
|    |    ├──Router.php
|    |    ├──routerInit.php
|    |
|    ├──Template
|       ├──Template.php
|  
├──DAO          
|   ├──DaoClasses      
|
├──Services          
|        ├──ServicesClasses     
|          
|          
├──Controllers          
|    ├──ControllerClasses 
|          
|         
├──Views          
|    ├──pageTemplates
|
|
├──database/
|        ├──databaseConnector.php
|        |
|        ├──dbConfig.php 
|
|
├──public/
|    ├──index.php
|    ├──.htaccess   
|
|
├──src/
|    ├──exceptions
|    ├──handlers
|    ├──helpers
| 
|
|
├──DockerEnvironment

```

### Docker окружение проекта

`.env` - файл конфигурации окружения, который содержит настройки для подключения к базе данных и другие параметры приложения.

`docker-compose.yml` - файл, который описывает сервисы, необходимые для работы приложения, такие как веб-сервер и база данных.

`Dockerfile` - файл, который содержит инструкции для создания образа Docker, включая установку необходимых зависимостей и настройку веб-сервера.

`apache.conf` - конфигурационный файл для веб-сервера Apache, который определяет настройки виртуального хоста и маршрутизацию запросов к приложению.

`.htaccess` - файл конфигурации Apache, который позволяет управлять доступом к ресурсам веб-приложения и настраивать переадресацию запросов.

### Запуск проекта

- Клонируйте репозиторий на свой компьюте
- В каталоге проекта запуск докер файла (DOcker и docker-compose должны быть установлены)
```bash
  docker-compose up -d --build
```
- После успешного запуска контейнеров, откройте веб-браузер и перейдите по адресу `http://localhost:8080` для доступа к приложению и `http://localhost:8081` для доступа к граф интерфейсу базы данных.
- Для доступа к панели используйте логин `user` и пароль `pass`.
- Импортируйте файл `studnet.sql` в базу данных `studnet` для создания необходимых таблиц и начальных данных по ссылке `https://drive.google.com/file/d/1A1wOxzwdxjKPwktBZZqmKHWRgLUFE5M_/view?usp=drive_link`.

### Описание проекта
- `StudNet` - это веб-приложение, которое предоставляет студентам доступ к новостям, полезным ресурсам и дополнительной информации о чем либо

### Функциональные возможности по требованиям к приложению
- Регистрация и аутентификация пользователей ✅
- Создание, редактирование и удаление постов ✅
- Добавление тегов к постам ✅
- Поиск постов по названию ✅
- Удаление, редактирование и информация о пользователе ✅
- Хеширование паролей пользователей ✅
- Валидация данных при регистрации и аутентификации пользователей ✅
- Валидация и фильтрация данных при создании и редактировании постов ✅
- Безопасное удаление сущностей ✅
- Использование шаблонов для отображения страниц ✅
- Использование маршрутизации для обработки запросов ✅

### Template и Router классы

- `Template` - класс, который отвечает за отображение страниц и управление шаблонами. Он использует метод `render`, чтобы загружать и отображать HTML-шаблоны с переданными данными
- `Router` - класс, который отвечает за маршрутизацию запросов. Он использует метод `addRoute`, чтобы добавлять маршруты и соответствующие обработчики для различных HTTP-методов (GET, POST). Метод `dispatch` обрабатывает входящие запросы и вызывает соответствующий контроллер.
- `routerInit` - файл, который инициализирует маршрутизатор и добавляет маршруты для различных страниц приложения. Он использует методы `addRoute` и `dispatch` для обработки запросов.

`Router.php`
```php
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
```
В данном классе реализованы методы для добавления маршрутов и их обработки. Метод `dispatch` проверяет, соответствует ли метод и путь маршруту, и вызывает соответствующий обработчик. Пример маршрута пбудет показан ниже

`Template.php`

```php
class Template
{
    private $layout;
    private $viewDirectory;

    /**
     * Конструктор класса
     *
     * @param string $layout
     * @param string $viewDirectory
     */
    public function __construct($layout, $viewDirectory){
        $this->viewDirectory = $viewDirectory;
        $this->layout = $viewDirectory . '/' . $layout . '.php';
    }

    /**
     * Загружает шаблон с данными
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    public function render($view, $data = []){
        extract($data);
        ob_start();
        include $this->viewDirectory . '/' . $view . '.php';
        $content = ob_get_clean();
        include $this->layout;
    }

}
```



### Регистрация и авторизация пользователей

1) Таблицы в бд, связанные с пользователем:

![](https://i.imgur.com/pdHlm9l.png)
- `users` - таблица, содержащая информацию о пользователях, включая их логин, пароль и роль.

![](https://i.imgur.com/iTANyc5.png)
- `roles` - таблица, содержащая информацию о ролях пользователей, таких как администратор или пользователь.

#### Логика регистрации пользователя:
- Пользователь заполняет форму регистрации, вводя логин, пароль и почту

DAO класс для работы с пользователями:
```php
    public function create($username, $password, $email)
    {
        $sql = "INSERT INTO users (username, password, email, role_id) VALUES (?, ?, ?, 2)";
        return $this->connection->prepare($sql)->execute([$username, hash('sha256', $password), $email]);
    }
```
пароль хешируется с помощью алгоритма `SHA-256` перед сохранением в базе данных

Service класс для работы с регистрацией:
```php
    public function create($user)
    {

        $username = $this->formValidator::sanitizeData($user['username'] ?? '');
        $password = $this->formValidator::sanitizeData($user['password'] ?? '');
        $email = $this->formValidator::sanitizeData($user['email'] ?? '');
        if (!$this->formValidator::requiredField($username) || !$this->formValidator::requiredField($password) || !$this->formValidator::requiredField($email)) {
            throw new CreateEntityException("Username, password, and email are required.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new CreateEntityException("Invalid email format.");
        }
        if (!$this->formValidator::validateForm(3, 20, $username)) {
            throw new CreateEntityException("Username must be between 3 and 20 characters.");
        }
        if (!$this->formValidator::validateForm(6, 20, $password)) {
            throw new CreateEntityException("Password must be between 6 and 20 characters.");
        }
        return $this->userDAO->create($username, $password, $email);
    }
```

Exception класс для обработки ошибок регистрации:

```php
<?php

class CreateEntityException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null){
        parent::__construct($message, $code, $previous);
    }
}
```

Метод создания user в контроллере:
```php
    public function createUser(){
        try {
            return $this->userService->create($_POST);
        } catch (\CreateEntityException $e) {
            return $e->getMessage();
        }
    }
```

Handler функция в  классе для работы с user:\

```php
    public function handleRegister(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
            $message = $this->userController->createUser();
            if (is_string($message)) {
                return $message;
            }
            return null;
        }
        return null;
    }
```

Controller для регистрации
```php
    public function register(){
        session_start();
        require_once __DIR__ . "/../../database/databaseConnector.php";
        $_SESSION['error'] = null;
        $handler = new UserFormHandler();
        $result = $handler->handleRegister();
        if(is_string($result)){
            $_SESSION['error'] = $result;
            return $result;
        }
        header('Location: /login');
        exit();
    }
```

Обработка запроса в роутере
```php
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
```

Представление:
```php
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4 class="mb-4 text-center">Hello new USER!</h4>
            <h2 class="mb-4 text-center">Register</h2>
            <form method="post">
                <input type="hidden" name="action" value="register">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label for="email">Password</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
            <div class="text-center mt-3">
                <a href="/login">Have an account?</a>
            </div>
            <?php
            if (!empty($error)) { ?>
                <div class="alert alert-danger mt-3" role="alert"><?= $error?></div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
```
Действие контроллеров и методов:

![](https://i.imgur.com/pmtlIMn.png)

![](https://i.imgur.com/549ijc7.png)

![](https://i.imgur.com/QmssTj4.png)

### Авторизация пользователя
- Пользователь вводит логин и пароль на странице входа
- Пароль сравнивается с хешем в базе данных
- Если совпадает, создается сессия и пользователь перенаправляется на главную страницу
- Если не совпадает, выводится сообщение об ошибке

```php
    /**
     * Выполняет вход пользователя в систему.
     *
     * Этот метод обрабатывает POST-запросы с действием "login".
     * Если учетные данные пользователя верны, создается сессия и пользователь перенаправляется на главную страницу.
     * В случае ошибки входа устанавливается сообщение об ошибке и выполняется перенаправление на страницу входа.
     */
    public function login()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
            $handler = new LoginHandler();
            $user = $handler->handleLogin($_POST);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role_id'] = $user['role_id'];
                $_SESSION['username'] = $user['username'];
                header("Location: /");
                exit;
            }
            $_SESSION['error'] = 'Wrong username or password';
            header("Location: /login");
            exit;
        }
    }
```

