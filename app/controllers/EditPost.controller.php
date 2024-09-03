<?php

require __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../models/EditPost.model.php';

class EditPostController
{
    public function updatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $category = $_POST['category'];
            $id = $_POST['post_id'];

            echo $id;
        }
    }
}

$init = new EditPostController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'update':
            $init->updatePost();
            break;
        default:
            // Handle other cases if needed
    }
}
