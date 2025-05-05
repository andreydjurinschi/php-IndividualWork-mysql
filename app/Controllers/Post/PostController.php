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

    public function getAllPosts(): array
    {
        $sort = $_GET['sort'] ?? 'desc';
        $posts = $this->postService->getAll($sort);

        foreach ($posts as &$post) {
            if (isset($post['tags'])) {
                $post['tags'] = explode(',', $post['tags']);
            } else {
                $post['tags'] = [];
            }
        }

        return $posts;
    }


    public function searchByTitle($title){
        $posts = $this->postService->searchByTitle($title);
        foreach ($posts as &$post) {
            if (isset($post['tags'])) {
                $post['tags'] = explode(',', $post['tags']);
            } else {
                $post['tags'] = [];
            }
        }
        return $posts;
    }

    public function searchPostsByTags(array $tagIds): array{
        return $this->postService->searchPostsByTags($tagIds);
    }




    public function updatePost($id)
    {
        try {
            return $this->postService->update($id, $_POST);
        } catch (\CreateEntityException $e) {
            return $e->getMessage();
        }
    }

    public function getPost($id)
    {
        return $this->postService->getPostById($id);
    }

}