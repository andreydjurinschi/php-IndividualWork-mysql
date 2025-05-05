<?php

namespace Controllers\Post;

use Services\TagService;
require_once __DIR__ . "/../../Services/TagService.php";

class TagController
{
    private $tagService;

    public function __construct()
    {
        $this->tagService = new TagService();
    }

    public function getAllTags(): array
    {
        return $this->tagService->getAllTags();
    }
    public function getTagForPost($post_id): array
    {
        return $this->tagService->getTagForPost($post_id);
    }
}


