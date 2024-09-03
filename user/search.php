<?php

require_once __DIR__ . '../../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = '%' . $_POST['searchInput'] . '%';

    if (empty($searchTerm)) {
        echo json_encode([]);
        exit;
    }

    $query = "SELECT id, title FROM posts WHERE title LIKE :query LIMIT 5;";

    $stmt = Database::conn()->prepare($query);
    $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
}
