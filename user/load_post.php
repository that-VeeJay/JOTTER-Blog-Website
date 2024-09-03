<?php

require __DIR__ . '/../app/models/PostRepository.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postNewCount = intval($_POST['postNewCount']);

    $postModel = new PostRepository();
    $posts = $postModel->loadMorePosts($postNewCount);

    foreach ($posts as $post): ?>
        <div class="sectionTwo__card">
            <div class="hover-image">
                <img class="sectionTwo__card-image" src="../assets/post/<?= htmlspecialchars($post['cover_image']); ?>" alt="">
            </div>

            <a href="category.php?category=<?= $post['category']; ?>" class="sectionTwo__card-category"><?= $post['category'] ?></a>
            <a class="sectionTwo__card-title" href="blog.php?id=<?= htmlspecialchars($post['post_id']); ?>"><?= htmlspecialchars($post['title']); ?></a>
            <div class="sectionTwo__card-info">
                <div class="sectionTwo-card-info-detail">
                    <img class="sectionTwo__card-info-profile" src="../assets/profile/<?= htmlspecialchars($post['profile_picture']); ?>" alt="">
                    <div class="sectionTwo__card-info-name"><?= htmlspecialchars($post['first_name']) . ' ' . htmlspecialchars($post['last_name']); ?></div>
                </div>
                <div class="sectionTwo__card-info-date"><?= date('F j, Y', strtotime($post['created_at'])); ?></div>
            </div>
        </div>
<?php endforeach;
}
