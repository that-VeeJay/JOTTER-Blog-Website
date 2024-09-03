<?php

require_once __DIR__ . '/../../config/Database.php';

class AddPostModel
{
    public function addPost($title, $content, $category, $coverImage, $userId)
    {
        $query = "
            INSERT INTO posts (title, content, category, cover_image, created_at, user_id)
            VALUES (:title, :content, :category, :cover_image, NOW(), :user_id);
        ";

        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':cover_image', $coverImage);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
