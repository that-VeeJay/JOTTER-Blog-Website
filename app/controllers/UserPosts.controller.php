<?php

require __DIR__ . '/../../config/constants.php';
require __DIR__ . '/../../app/models/UserPosts.model.php';

class UserPostsController
{

    private $userPostModel;

    public function __construct()
    {
        $this->userPostModel = new UserPostsModel();
    }

    public function deleteUserPost()
    {
        if (isset($_POST['post_id'])) {
            $id = $_POST['post_id'];
        }

        $this->userPostModel->deleteUserPost($id);
        header('Location: ' . ROOT_URL . 'user/profile.php');
        exit();
    }
}



$init = new UserPostsController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'delete':
            $init->deleteUserPost();
            break;
        default:
            break;
    }
}
