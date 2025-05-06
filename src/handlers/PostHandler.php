<?php

namespace handlers;
require_once __DIR__ . "/../../app/Controllers/Post/PostController.php";
use Controllers\Post\PostController;
class PostHandler
{
    private $postController;
    public function __construct()
    {
        $this->postController = new PostController();
    }

    public function handleCreatePost(): ?string
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_post') {

            $message = $this->postController->createPost();
            $POST = [];
            if (is_string($message)) {
                return $message;
            }
            return null;
        }
        return null;
    }

    public function handleUpdatePost($id): ?string
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_post') {
            $message = $this->postController->updatePost($id);
            $POST = [];
            if (is_string($message)) {
                return $message;
            }
            return null;
        }
        return null;
    }

    public function handleDeletePost(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_post') {
            try {
                $success = $this->postController->deletePost($id);
                if (!$success) {
                    return 'Failed to delete post.';
                }
                return true;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        return 'Invalid request.';
    }

}