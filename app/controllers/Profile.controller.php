<?php

require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '../../models/Profile.model.php';

class ProfileController
{
    private $profileModel;

    public function __construct()
    {
        $this->profileModel = new ProfileModel();
    }

    public function loadPosts()
    {
        return $this->profileModel->getUserPosts($_SESSION['user-id']);
    }

    public function loadProfile()
    {
        return $this->profileModel->getUserDetails($_SESSION['user-id']);
    }

    public function handleUserPost() {
        
    }

    private function handleFileUpload(&$profilePicture)
    {
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
            return;
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

        if ($fileSize > 1000000) {
            $this->sendErrorResponse('Your file is too big.');
        }

        $fileNewName = uniqid('', true) . '.' . $fileExt;
        $fileDestination = __DIR__ . '/../../assets/profile/' . $fileNewName;

        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            $profilePicture = $fileNewName;
        } else {
            $this->sendErrorResponse('Failed to upload file.');
        }
    }

    private function sendErrorResponse($message)
    {
        echo $message;
        exit;
    }

    public function updateProfile()
    {
        $userId = $_SESSION['user-id'];
        $updateData = [
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'bio' => $_POST['bio'] ?? ''
        ];

        $currentDetails = $this->profileModel->getUserDetails($userId);
        $profilePicture = $currentDetails['profile_picture'];

        $this->handleFileUpload($profilePicture);

        $firstName = $updateData['first_name'] ?: $currentDetails['first_name'];
        $lastName = $updateData['last_name'] ?: $currentDetails['last_name'];
        $bio = $updateData['bio'] ?: $currentDetails['bio'];

        $this->profileModel->updateUserDetails($firstName, $lastName, $bio, $userId, $profilePicture);

        header('Location: ' . ROOT_URL . 'user/profile.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $init = new ProfileController();
    $init->updateProfile();
}
