<?php

namespace Services;

use DAO\Posts\PostDAOImpl;
use helpers\FormValidator;
use CreateEntityException;

require_once __DIR__ . "/../DAO/Posts/PostDAOImpl.php";
require_once __DIR__ . "/../../src/helpers/FormValidator.php";
require_once __DIR__ . "/../../src/exceptions/CreateEntityException.php";

/**
 * Класс PostService предоставляет методы для управления постами.
 */
class PostService
{
    /**
     * @var PostDAOImpl Экземпляр DAO для работы с постами.
     */
    private $postDao;

    /**
     * @var FormValidator Экземпляр валидатора форм.
     */
    private $formValidator;

    public function __construct()
    {
        $this->postDao = new PostDAOImpl();
        $this->formValidator = new FormValidator();
    }

    /**
     * Получает все посты с использованием DAO.
     *
     * @return array Возвращает массив всех постов.
     */
    public function getAll(string $sort = 'desc'): array
    {
        return $this->postDao->getAll($sort);
    }
    /**
     * Создает новый пост.
     *
     * @param array $post Ассоциативный массив с данными поста (title, content, photo_path, file_path).
     * @return mixed Результат создания поста.
     * @throws CreateEntityException Если данные поста не проходят валидацию.
     */
    public function create($post)
    {
        $title = $this->formValidator::sanitizeData($post['title'] ?? '');
        $content = $this->formValidator::sanitizeData($post['content'] ?? '');
        $photo_path = $this->formValidator::sanitizeData($post['photo_path'] ?? null);
        $file_path = $this->formValidator::sanitizeData($post['file_path'] ?? null);
        $tags = [];
        if (isset($post['tags']) && is_array($post['tags'])) {
            foreach ($post['tags'] as $tag) {
                $tags[] = $this->formValidator::sanitizeData($tag);
            }
        }

        if (!$this->formValidator::requiredField($title) || !$this->formValidator::requiredField($content)) {
            throw new CreateEntityException("Title and content are required.");
        }
        if (!$this->formValidator::validateForm(5, 60, $title) || !$this->formValidator::validateForm(5, 500, $content)) {
            throw new CreateEntityException("Title must be between 5 and 60 characters. Content must be between 5 and 500 characters.");
        }

        return $this->postDao->create($title, $content, $photo_path, $file_path, $tags);
    }



    /**
     * Получает пост по его ID.
     *
     * @param int $id ID поста.
     * @return array|null Возвращает массив с данными поста или null, если пост не найден.
     */
    public function getPostById($id): ?array
    {
        $post = $this->postDao->findById($id);
        if ($post) {
            return $post;
        }
        return null;
    }

    public function searchByTitle($title){
        return $this->postDao->searchByTitle($title);
    }

    /**
     * Обновляет существующий пост.
     *
     * @param int $id ID поста.
     * @param array $post Ассоциативный массив с данными поста (title, content, photo_path, file_path).
     * @return mixed Результат обновления поста.
     * @throws CreateEntityException Если данные поста не проходят валидацию.
     */
    public function update($id, $post)
    {

        $title = $this->formValidator::sanitizeData($post['title'] ?? '');
        $content = $this->formValidator::sanitizeData($post['content'] ?? '');
        $photo_path = $this->formValidator::sanitizeData($post['photo_path'] ?? null);
        $file_path = $this->formValidator::sanitizeData($post['file_path'] ?? null);
        $tags = [];
        if (isset($post['tags']) && is_array($post['tags'])) {
            foreach ($post['tags'] as $tag) {
                $tags[] = $this->formValidator::sanitizeData($tag);
            }
        }

        if (!$this->formValidator::requiredField($title) || !$this->formValidator::requiredField($content)) {
            throw new CreateEntityException("Title and content are required.");
        }
        if (!$this->formValidator::validateForm(5, 60, $title) || !$this->formValidator::validateForm(5, 500, $content)) {
            throw new CreateEntityException("Title must be between 5 and 60 characters. Content must be between 5 and 500 characters.");
        }

        return $this->postDao->update($id, $title, $content, $photo_path, $file_path, $tags);
    }

    public function searchPostsByTags(array $tags)
    {
        return $this->postDao->searchPostsByTags($tags);
    }
}
