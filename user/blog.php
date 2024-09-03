<?php
$title = 'Blog';
$stylesheet = 'blog';

require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/navbar.php';
require __DIR__ . '/../helpers/user_helper.php';
require __DIR__ . '/../app/models/PostRepository.model.php';

checkUserSessionAndRedirect();

$articleModel = new PostRepository();
$article = $articleModel->getArticle($_GET['id']);
?>

<body>
    <!-- article -->
    <div class="article__hero">
        <div class="article">
            <div class="article__head">
                <div class="article__title"><?= $article['title']; ?></div>
                <a href="homepage.php"><img class="back__arrow" src="/assets/icons/back-arrow.svg" alt=""></a>
            </div>
            <div class="article__user">
                <img class="article__user--profile" src="../assets/profile/<?= $article['profile_picture']; ?>" alt="">
                <div class="article__info">
                    <div class="name"><?= $article['first_name']; ?> <?= $article['last_name']; ?></div>
                    <div class="date"><?= date('M d, Y - h:ia', strtotime($article['created_at'])); ?></div>
                </div>
            </div>
            <img class="article__image responsive-image" src="/assets/post/<?= $article['cover_image']; ?>" alt="">
            <div class="article__category"><?= $article['category'] ?></div>
            <div class="article__content"><?= nl2br($article['content']); ?></div>
        </div>
    </div>

    <?php require __DIR__ . '/partials/footer.php'; ?>
</body>

</html>
