<?php

require_once __DIR__ . '/../../config/Database.php';

class AdminDashboardModel
{
    public function getNumberOfUsers(): int
    {
        $query = "SELECT * FROM users;";
        $stmt = Database::conn()->prepare($query);
        $stmt->execute();
        $result = $stmt->rowCount();

        return $result;
    }

    public function getNumberOfPosts(): int
    {
        $query = "SELECT * FROM posts;";
        $stmt = Database::conn()->prepare($query);
        $stmt->execute();
        $result = $stmt->rowCount();

        return $result;
    }

    public function getActiveUsers(): array
    {
        $query = "SELECT profile_picture, first_name, last_name, created_at FROM users;";
        $stmt = Database::conn()->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
