<?php
$title = 'Category';
$stylesheet = 'category';

require __DIR__ . '../../user/partials/head.php';
require __DIR__ . '../../user/partials/navbar.php';
require __DIR__ . '/../app/models/PostRepository.model.php';

$postsModel = new PostRepository();
$posts = $postsModel->getCategoryPost($_GET['category']);
?>


<body>

    <div class="category__background">
        <div class="category__title"><?= strtoupper($_GET['category']); ?></div>
    </div>

    <div class="sectionTwo container grid" id="yow">
        <?php foreach ($posts as $post): ?>
            <div class="sectionTwo__card">
                <div class="hover-image">
                    <img class="sectionTwo__card-image" src="../assets/post/<?= $post['cover_image'] ?>" alt="Post Image">
                </div>
                <div class="sectionTwo__card-category"><?= $post['category']; ?></div>
                <a class="sectionTwo__card-title" href="blog.php?id=<?= $post['post_id']; ?>"><?= $post['title']; ?></a>
                <div class="sectionTwo__card-info">
                    <div class="sectionTwo-card-info-detail">
                        <img class="sectionTwo__card-info-profile" src="../assets/profile/<?= $post['profile_picture']; ?>" alt="Profile Picture">
                        <div class="sectionTwo__card-info-name"><?= $post['first_name'] . ' ' . $post['last_name']; ?></div>
                    </div>
                    <div class="sectionTwo__card-info-date"><?= date('F j, Y', strtotime($post['created_at'])) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</>
