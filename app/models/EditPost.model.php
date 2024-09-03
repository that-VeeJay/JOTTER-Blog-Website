<?php

require_once __DIR__ . '/../../config/Database.php';

class EditPostModel
{
    public function updatePost($title, $content, $category, $coverImage, $id)
    {
        $query = "UPDATE posts SET title = :title, content = :content, category = :category" .
            ($coverImage ? ", cover_image = :cover_image" : "") .
            " WHERE id = :id";

        $stmt = Database::conn()->prepare($query);

        $params = [
            ':title' => $title,
            ':content' => $content,
            ':category' => $category,
            ':id' => $id,
        ];

        if ($coverImage) {
            $params[':cover_image'] = $coverImage;
        }

        $stmt->execute($params);
    }
}
