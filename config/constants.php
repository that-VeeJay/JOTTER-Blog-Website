<?php

session_status() === PHP_SESSION_NONE ? session_start() : null;

if (!defined('ROOT_URL')) {
    define('ROOT_URL', 'http://jotter.com/');
}

// if (!defined('APP_NAME')) {
//     define('APP_PATH', dirname(__FILE__) . '/../');
// }
