<?php

require __DIR__ . '../../config/constants.php';

// Start a session if it's not already started
function initializeSession()
{
    session_status() === PHP_SESSION_NONE ? session_start() : null;
}


function redirectUserBasedOnSession()
{
    if (isset($_SESSION['loggedIn-user'])) {
        header('Location: ' . ROOT_URL . 'user/homepage.php');
        exit();
    } elseif (isset($_SESSION['loggedIn-admin'])) {
        header('Location: ' . ROOT_URL . 'admin/homepage.php');
        exit();
    }
}

function displaySessionMessage()
{
    if (!empty($_SESSION['message'])) {
        $message = is_array($_SESSION['message'])
            ? $_SESSION['message'][0]
            : $_SESSION['message'];
        $messageType = $message === 'Registration successful!' ? 'success' : 'failed';
        echo "<div class=\"{$messageType}__message\">{$message}</div>";
        $_SESSION['message'] = [];
    }
}

function getSessionUserInput()
{
    return $_SESSION['user_inputs'] ?? [];
}

function getSessionEmail()
{
    return $_SESSION['email'] ?? '';
}
