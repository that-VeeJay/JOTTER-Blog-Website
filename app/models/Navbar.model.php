<?php

class NavbarModel
{
    public function getUserProfileImage($id)
    {
        require_once __DIR__ . '/../../config/Database.php';
        $query = "SELECT profile_picture FROM users WHERE id = :id;";
        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['profile_picture'];
    }
}
