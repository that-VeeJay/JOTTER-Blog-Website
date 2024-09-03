<?php
$title = 'Profile';
$stylesheet = 'profile';

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/navbar.php';
require_once __DIR__ . '/../helpers/user_helper.php';
require_once __DIR__ . '/../app/controllers/Profile.controller.php';

checkUserSessionAndRedirect();

$profileController = new ProfileController();
$profileData = [];
$postsData = [];

if (isset($_SESSION['user-id'])) {
    $profileData = $profileController->loadProfile();
    $postsData = $profileController->loadPosts();
}
?>

<body>
    <!-- Profile -->
    <div class="profile-container">
        <div class="profile-details">
            <img class="profile-picture" src="/assets/profile/<?= htmlspecialchars($profileData['profile_picture'], ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Picture">
            <div class="profile-name">
                <div class="profile-first-name"><?= htmlspecialchars($profileData['first_name'], ENT_QUOTES, 'UTF-8'); ?></div>
                <div class="profile-last-name"><?= htmlspecialchars($profileData['last_name'], ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <div class="profile-bio"><?= htmlspecialchars($profileData['bio'], ENT_QUOTES, 'UTF-8'); ?></div>
        </div>

        <!-- View Posts -->
        <div class="profile-posts-header">View Posts</div>
        <div class="profile-posts">
            <?php foreach ($postsData as $data): ?>
                <div class="post-item" data-post-id="<?= htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-title="<?= htmlspecialchars($data['title'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-image="<?= htmlspecialchars($data['cover_image'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-content="<?= htmlspecialchars($data['content'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-category="<?= htmlspecialchars($data['category'], ENT_QUOTES, 'UTF-8'); ?>">

                    <img class="three-dots" src="/assets/icons/three-dots.svg" alt="Options">
                    <div class="post-title"><?= htmlspecialchars($data['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <img class="post-image" src="/assets/post/<?= htmlspecialchars($data['cover_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Post Image">
                </div>
            <?php endforeach; ?>
        </div>


        <!-- Edit/Delete Modal -->
        <div id="editDeleteModal" class="modal">
            <div class="edit-modal-content">
                <div class="modal-body">
                    <!-- <button type="button" id="editPostBtn" onclick="setActionType('update')">Edit</button> -->
                    <button type="button" id="editPostBtn">Edit</button>
                    <form id="editDeleteForm" action="../app/controllers/UserPosts.controller.php" method="POST">
                        <input type="hidden" id="actionType" name="type" value="">
                        <input type="hidden" id="postId" name="post_id" value="">

                        <button type="button" id="deletePostBtn" onclick="setActionType('delete')">Delete</button>
                    </form>
                </div>
            </div>
        </div>



        <!-- Update Post Form Modal -->

        <div id="modal-overlay">
            <div class="edit-post-modal">
                <div class="ep__header">
                    <h3>Edit Post</h3>
                    <span id="modalClose" class="modalClose">&times;</span>
                </div>
                <form class="ep__form" action="update_post.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="updatePostId" name="post_id" value="">
                    <input type="hidden" id="actionType" name="type" value="">
                    <div class="ep__input">
                        <label for="">Edit Title</label>
                        <input type="text" id="edit-title" name="title">
                    </div>
                    <div class="ep__input">
                        <label for="">Replace Image</label>
                        <input type="file" id="edit-image" name="image">
                    </div>
                    <div class="ep__input">
                        <label for="">Edit Content</label>
                        <textarea id="edit-content" name="content"></textarea>
                    </div>
                    <div class="ep__input">
                        <label for="post-category">Category</label>
                        <select id="post-category" class="input__field" name="category" required>
                            <option value="" disabled selected>Select a category</option>
                            <option value="Technology">Technology</option>
                            <option value="Lifestyle">Lifestyle</option>
                            <option value="Health">Health</option>
                            <option value="Food">Food</option>
                            <option value="Travel">Travel</option>
                            <option value="Music">Music</option>
                            <option value="Gaming">Gaming</option>
                            <option value="Academics">Academics</option>
                        </select>
                    </div>
                    <button type="submit" onclick="setActionType('update')" class="ep__submit-changes">Submit Changes</button>
                </form>
            </div>
        </div>

        <?php
        require_once __DIR__ . '/partials/edit_profile_modal.php';
        require_once __DIR__ . '/partials/add_post_modal.php';
        require_once __DIR__ . '/partials/floating_action_button.php';
        ?>

        <script defer src="js/modals.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('editDeleteModal');
                const threeDotsButtons = document.querySelectorAll('.post-item .three-dots');
                const form = document.getElementById('editDeleteForm');
                const actionTypeInput = document.getElementById('actionType');
                const postIdInput = document.getElementById('postId');
                let currentPostId;

                const editPostBtn = document.getElementById('editPostBtn');
                const editModal = document.getElementById('modal-overlay');
                const modalClose = document.getElementById('modalClose');

                const editTitleInput = document.getElementById('edit-title');
                const editContentTextarea = document.getElementById('edit-content');
                const editCategorySelect = document.getElementById('post-category');
                const updatePostIdInput = document.getElementById('updatePostId');
                const updatePostForm = document.getElementById('updatePostForm');


                editPostBtn.addEventListener('click', () => {

                    const postItem = document.querySelector(`.post-item[data-post-id="${currentPostId}"]`);
                    if (postItem) {
                        editTitleInput.value = postItem.getAttribute('data-title');
                        editContentTextarea.value = postItem.getAttribute('data-content');
                        editCategorySelect.value = postItem.getAttribute('data-category');

                    }
                    updatePostIdInput.value = currentPostId;

                    editModal.style.display = 'block';
                });

                modalClose.addEventListener('click', () => {
                    editModal.style.display = 'none';
                })

                threeDotsButtons.forEach(button => {
                    button.addEventListener('click', function(event) {
                        // Prevents default click behavior and stop event propagation
                        event.stopPropagation();

                        // Set the post ID for reference
                        currentPostId = this.parentElement.getAttribute('data-post-id');

                        // Set the post ID in the hidden input field
                        postIdInput.value = currentPostId;

                        // Position the modal under the clicked button
                        const rect = this.getBoundingClientRect();
                        modal.style.left = `${rect.left}px`;
                        modal.style.top = `${rect.bottom + window.scrollY}px`;

                        // Show the modal
                        modal.style.display = 'block';
                    });
                });

                window.setActionType = function(type) {
                    const actionTypeInput = document.getElementById('actionType');
                    actionTypeInput.value = type;
                    // Submit the form
                    if (type === 'update') {
                        updatePostForm.submit();
                    }
                };

                // Set the action type in the hidden input field and submit the form
                window.setActionType = function(type) {
                    if (currentPostId) {
                        actionTypeInput.value = type;
                        form.submit();
                    }
                };

                // Close the modal when clicking outside of it
                window.addEventListener('click', function(event) {
                    if (modal.contains(event.target)) {
                        modal.style.display = 'none';
                    }
                    modal.style.display = 'none';
                });
            });
        </script>
</body>

</html>
