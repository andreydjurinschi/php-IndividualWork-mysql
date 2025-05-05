<?php

namespace Services;
use DAO\Tags\TagDAOImpl;
use helpers\FormValidator;
use CreateEntityException;

require_once __DIR__ . "/../DAO/Tags/TagDAOImpl.php";
require_once __DIR__ . "/../../src/helpers/FormValidator.php";
require_once __DIR__ . "/../../src/exceptions/CreateEntityException.php";
class TagService
{
    /**
     * @var TagDAOImpl Экземпляр DAO для работы с постами.
     */
    private $tagDao;

    /**
     * @var FormValidator Экземпляр валидатора форм.
     */
    private $formValidator;

    public function __construct()
    {
        $this->tagDao = new TagDAOImpl();
        $this->formValidator = new FormValidator();
    }

    public function getAllTags(): array
    {
        return $this->tagDao->getAllTags();
    }

}