<?php

require_once __DIR__ . '/../../config/Database.php';

class ProfileModel
{
    public function getUserDetails($id): array
    {
        $query = "SELECT first_name, last_name, bio, profile_picture FROM users WHERE id = :id;";
        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Database::closeConnection();

        return $result;
    }

    public function updateUserDetails($firstName, $lastName, $bio, $id, $picture): void
    {
        $query = "UPDATE users SET first_name = :first_name, last_name = :last_name, bio = :bio, profile_picture = :profile_picture WHERE id = :id";
        $stmt = Database::conn()->prepare($query);
        $params = [
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':bio' => $bio,
            ':id' => $id,
            ':profile_picture' => $picture,
        ];
        $stmt->execute($params);
        Database::closeConnection();
    }

    public function getUserPosts($id): array
    {
        $query = "SELECT id, title, cover_image, content, category FROM posts WHERE user_id = :id ORDER BY created_at DESC;";
        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Database::closeConnection();

        return $result;
    }

    public function deletePost($postId)
    {
        $query = "DELETE FROM posts WHERE id = :id AND user_id = :user_id";
        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $_SESSION['user-id'], PDO::PARAM_INT);

        return $stmt->execute();
    }
}
