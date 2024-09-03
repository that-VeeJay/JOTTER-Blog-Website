<?php

require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '../../models/AddPost.model.php';

class AddPostController
{
    private $addPostModel;

    public function __construct()
    {
        $this->addPostModel = new AddPostModel();
    }

    private function sendErrorResponse($message)
    {
        echo $message;
        exit;
    }

    private function handleImageUpload()
    {
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
            $this->sendErrorResponse('File upload error.');
            return null;
        }

        $file = $_FILES['file'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png'];

        if (!in_array($fileExt, $allowedExt)) {
            $this->sendErrorResponse('You cannot upload files of this type.');
        }

        if ($fileError !== 0) {
            $this->sendErrorResponse('There was an error uploading your file.');
        }

        if ($fileSize > 10000000) {
            $this->sendErrorResponse('Your file is too big.');
        }

        $fileNewName = uniqid('', true) . '.' . $fileExt;
        $fileDestination = __DIR__ . '/../../assets/post/' . $fileNewName;

        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            return $fileNewName;
        } else {
            $this->sendErrorResponse('Failed to upload file.');
        }
    }

    public function addPost()
    {
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $category = $_POST['category'] ?? '';

        $coverImage = '';
        if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
            $coverImage = $this->handleImageUpload();
        }

        $userId = $_SESSION['user-id'];

        if ($this->addPostModel->addPost($title, $content, $category, $coverImage, $userId)) {
            header('Location: ' . ROOT_URL . 'user/profile.php');
            exit;
        } else {
            $this->sendErrorResponse('Failed to add post.');
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $init = new AddPostController();
    $init->addPost();
}
