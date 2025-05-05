<?php

namespace Controllers\Post;
use Services\PostService;

require_once __DIR__ . "/../../Services/PostService.php";

class PostController
{

    private $postService;

    public function __construct(){
        $this->postService = new PostService();
    }

    public function createPost(){
        try {
            return $this->postService->create($_POST);
        } catch (\CreateEntityException $e) {
            return $e->getMessage();
        }
    }

    public function getAllPosts(): array {
        return $this->postService->getAllPosts();
    }

    public function updatePost($id)
    {
        return $this->postService->update($id, $_POST);
    }

    public function getPost($id)
    {
        return $this->postService->getPostById($id);
    }

}