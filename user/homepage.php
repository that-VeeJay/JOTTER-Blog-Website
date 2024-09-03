<?php
$title = 'Home';
$stylesheet = 'style';

require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/navbar.php';
require __DIR__ . '/../helpers/user_helper.php';
require __DIR__ . '/../app/models/PostRepository.model.php';

checkUserSessionAndRedirect();

$postsModel = new PostRepository();
$highlightPost = $postsModel->getHighlightPost();
$posts = $postsModel->loadPosts();
?>

<body>
    <!-- HIGHLIGHT -->
    <div class="sectionOne container">
        <img src="../assets/post/<?= $highlightPost['cover_image']; ?>" class="sectionOne__post responsive-image" alt="">
        <div class="sectionOne__card">

            <a href="category.php?category=<?= $highlightPost['category']; ?>" class="sectionOne__card-category"><?= $highlightPost['category'] ?></a>
            <a class="sectionOne__card-title" href="blog.php?id=<?= $highlightPost['post_id'] ?>"><?= $highlightPost['title']; ?></a>
            <div class="sectionOne__card-info">
                <div class="sectionOne__card-info-1">
                    <img class="sectionOne__card-info-profile" src="../assets/profile/<?= $highlightPost['profile_picture']; ?>" alt="">
                    <div class="sectionOne__card-info-name"><?= $highlightPost['first_name']; ?> <?= $highlightPost['last_name']; ?>
                    </div>
                </div>
                <div class="sectionOne__card-info-date">
                    <?= date('F j, Y - g:i A', strtotime($highlightPost['created_at'])) ?>
                </div>
            </div>
        </div>
    </div>


    <div class="category__list container">
        <a href="category.php?category=Lifestyle" class="cat_name">Lifestyle</a>
        <a href="category.php?category=Technology" class="cat_name">Technology</a>
        <a href="category.php?category=Health" class="cat_name">Health</a>
        <a href="category.php?category=Food" class="cat_name">Food</a>
        <a href="category.php?category=Travel" class="cat_name">Travel</a>
        <a href="category.php?category=Music" class="cat_name">Music</a>
        <a href="category.php?category=Academics" class="cat_name">Academics</a>
        <a href="category.php?category=Gaming" class="cat_name">Gaming</a>
    </div>


    <div class="latest-post container">Latest Post</div>

    <!-- POSTS -->
    <div class="sectionTwo container grid" id="yow">
        <?php foreach ($posts as $post): ?>
            <div class="sectionTwo__card">
                <div class="hover-image">
                    <img class="sectionTwo__card-image" src="../assets/post/<?= $post['cover_image'] ?>" alt="">
                </div>
                <a href="category.php?category=<?= $post['category']; ?>" class="sectionTwo__card-category"><?= $post['category'] ?></a>
                <a class="sectionTwo__card-title" href="blog.php?id=<?= $post['post_id'] ?>"><?= $post['title'] ?></a>
                <div class="sectionTwo__card-info">
                    <div class="sectionTwo-card-info-detail">
                        <img class="sectionTwo__card-info-profile" src="../assets/profile/<?= $post['profile_picture'] ?>" alt="">
                        <div class="sectionTwo__card-info-name"><?= $post['first_name'] . ' ' . $post['last_name'] ?></div>
                    </div>
                    <div class="sectionTwo__card-info-date"><?= date('F j, Y', strtotime($post['created_at'])) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="button-container">
        <button id="load-more-btn">Load More</button>
    </div>
    <?php require __DIR__ . '/partials/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let postCount = 9;

            const loadMoreBtn = document.getElementById('load-more-btn');
            const morePostDiv = document.getElementById('yow');

            loadMoreBtn.addEventListener('click', () => {
                fetch('load_post.php', {
                        method: 'POST',
                        headers: {
                            'Content-type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            postNewCount: postCount
                        })
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data.trim() !== '') {
                            morePostDiv.innerHTML += data;
                            postCount += 9;
                        } else {
                            loadMoreBtn.style.display = 'none';
                        }
                    })
            })
        })
    </script>
</body>

</html>
