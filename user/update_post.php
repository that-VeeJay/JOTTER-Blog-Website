<?php

require __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];
    $id = $_POST['post_id'];

    $imagePath = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExts)) {

            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = __DIR__ . '/../assets/post/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagePath = $newFileName;
            } else {
                echo 'Error moving the uploaded file.';
                exit();
            }
        } else {
            echo 'Upload failed. Allowed file types: jpg, jpeg, png, gif.';
            exit();
        }
    }

    try {
        $db = Database::conn();
        if ($imagePath) {
            $query = "UPDATE posts SET title = :title, content = :content, category = :category, cover_image = :cover_image WHERE id = :id;";
            $params = [
                ':title' => $title,
                ':content' => $content,
                ':category' => $category,
                ':cover_image' => $imagePath,
                ':id' => $id,
            ];
        } else {
            $query = "UPDATE posts SET title = :title, content = :content, category = :category WHERE id = :id;";
            $params = [
                ':title' => $title,
                ':content' => $content,
                ':category' => $category,
                ':id' => $id,
            ];
        }
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        header('Location: ' . ROOT_URL . 'user/profile.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
