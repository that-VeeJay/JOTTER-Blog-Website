<?php

require_once __DIR__ . '/../../config/Database.php';

class RegisterModel
{

    public function getEmail(string $email): bool
    {
        $query = "SELECT email FROM users WHERE email = :email;";
        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->rowCount();
        Database::closeConnection();

        return (!empty($result)) ? true : false;
    }

    public function insertUserToDb(array $userInputs): bool
    {
        $query = "INSERT INTO users (first_name, last_name, email, password) VALUE (:first_name, :last_name, :email, :password);";
        $stmt = Database::conn()->prepare($query);
        $params = [
            ':first_name' => $userInputs['first_name'],
            ':last_name' => $userInputs['last_name'],
            ':email' => $userInputs['email'],
            ':password' => password_hash($userInputs['password'], PASSWORD_BCRYPT),
        ];
        Database::closeConnection();

        return $stmt->execute($params);
    }
}
