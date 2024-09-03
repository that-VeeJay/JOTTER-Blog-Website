<?php

require_once __DIR__ . '/../../config/Database.php';

class UserPostsModel
{
    public function deleteUserPost($postId)
    {
        $query = "DELETE FROM posts WHERE id = :id;";
        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':id', $postId);
        return $stmt->execute();
    }
}
