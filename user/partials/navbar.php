<?php

require_once __DIR__ . '/../../app/models/Navbar.model.php';

session_status() === PHP_SESSION_NONE ? session_start() : null;

$id = null;
if (isset($_SESSION['user-id'])) {
    $id = $_SESSION['user-id'];
}

$navbarModel = new NavbarModel();
$pp = null;

if ($id !== null) {
    $pp = $navbarModel->getUserProfileImage($id);
} else {
    $pp = ['profile_picture' => 'blank-profile.jpg'];
}

?>

<!-- navbar -->
<div class="hero">
    <nav class="navbar container">
        <div class="navbar__logo">
            <a class="logo__link" href="homepage.php">
                <img class="navbar__logo-img" src="../assets/logo/LogoDark.svg" alt="">
                <div class="navbar__logo-text" style="text-decoration: none;">JOTTER</div>
            </a>
        </div>
        <div class="navbar__menu">
            <a href="homepage.php" class="navbar__menu-1">Home</a>
            <a href="feedback.php" class="navbar__menu-2">Feedback</a>
            <a href="about.php" class="navbar__menu-3">About</a>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Search...">
            <div id="search-results" class="results-dropdown">

            </div>
        </div>

        <img class="navbar__profile" src="../assets/profile/<?= $pp ?>" alt="">
        <div class="navbar__icon">
            <i class="bi bi-list"></i>
        </div>

        <div class="sub__menu">
            <a class="sub__menu--profile" href="./profile.php">Profile</a>
            <a class="sub__menu--logout" href="../logout.php">Logout</a>
        </div>
    </nav>
</div>
