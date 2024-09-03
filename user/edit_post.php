<?php

require __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'update') {
    echo $_POST['post_id'];
}
