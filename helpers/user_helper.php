<?php

function checkUserSessionAndRedirect()
{
    require __DIR__ . '../../config/constants.php';

    if (!isset($_SESSION['loggedIn-user'])) {
        header('Location: ' . ROOT_URL . 'login.php');
        exit();
    }
}
