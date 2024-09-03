<?php

require __DIR__ . '/config/constants.php';

session_destroy();
session_unset();
header('Location: ' . ROOT_URL . 'login.php');
exit();
