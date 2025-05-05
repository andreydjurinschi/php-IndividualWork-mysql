<?php

namespace DAO\Posts;

interface PostDAO
{
    public function getAll();
    public function create($title, $content,?string $photo_path, ?string $file_path);
    public function findById(int $id);
    public function update($id, $title, $content,$photo_path,$file_path);
    public function delete($id);

    public function addTagToPost(?int $post_id,?int $tag_id);

    public function searchByTitle($title);
}