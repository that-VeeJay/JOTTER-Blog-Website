<?php

require_once __DIR__ . '/../../config/Database.php';

class LoginModel
{
    public function getHashedPassword(string $email): ?string
    {
        $query = "SELECT password FROM users WHERE email = :email;";
        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Database::closeConnection();

        return $result['password'] ?? null;
    }

    public function getUserType(string $email): ?string
    {
        $query = "SELECT user_type FROM users WHERE email = :email;";
        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Database::closeConnection();

        return $result['user_type'] ?? null;
    }

    public function getUserId(string $email): ?string
    {
        $query = "SELECT id FROM users WHERE email = :email;";
        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Database::closeConnection();

        return $result['id'] ?? null;
    }
}
