<?php

namespace Services;

use DAO\User\UserDaoImpl;
use helpers\FormValidator;
use CreateEntityException;

require_once __DIR__ . "/../DAO/User/UserDaoImpl.php";
require_once __DIR__ . "/../../src/helpers/FormValidator.php";
require_once __DIR__ . "/../../src/exceptions/CreateEntityException.php";

/**
 * Класс UserService предоставляет методы для управления пользователями.
 */
class UserService
{
    /**
     * @var UserDaoImpl Экземпляр DAO для работы с пользователями.
     */
    private $userDAO;

    /**
     * @var FormValidator Экземпляр валидатора форм.
     */
    private $formValidator;

    /**
     * Конструктор класса UserService.
     * Инициализирует объекты UserDaoImpl и FormValidator.
     */
    public function __construct()
    {
        $this->userDAO = new UserDaoImpl();
        $this->formValidator = new FormValidator();
    }

    public function getAllUsers(): array {
        return $this->userDAO->getAll();
    }

    /**
     * Создает нового пользователя.
     *
     * @param array $user Ассоциативный массив с данными пользователя (username, password, email).
     * @return mixed Результат создания пользователя.
     * @throws CreateEntityException Если данные пользователя не проходят валидацию.
     */
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


    /**
     * Обновляет данные существующего пользователя.
     *
     * @param array $user Ассоциативный массив с данными пользователя (username, password, email, role_id).

     * @return bool Возвращает true, если данные пользователя успешно обновлены, иначе false.
     */
    public function update($user)
    {
        $id = $this->formValidator::sanitizeData($user['id'] ?? '');
        $role_id = $this->formValidator::sanitizeData($user['role_id'] ?? '');

        $role_id = (int)$role_id;
        $id = (int)$id;

        return $this->userDAO->update($id, $role_id);
    }

    public function getById(int $id) {
        return $this->userDAO->findById($id);
    }
}