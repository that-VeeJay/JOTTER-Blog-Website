<div id="addPostModal" class="postModal">
    <div class="post-modal-content">
        <div>
            <span class="close-edit-modal modalClose">&times;</span>
            <h3>Add New Post</h3>
        </div>
        <form class="update__form" action="../app/controllers/AddPost.controller.php" method="POST" enctype="multipart/form-data">
            <!-- Title Input -->
            <div>
                <label for="post-title">Title</label>
                <input type="text" id="post-title" class="input__field" name="title" required>
            </div>
            <!-- Image Upload -->
            <div class="image">
                <label for="post-image">Upload Image</label>
                <input type="file" id="post-image" name="file" class="thumbnail" required>
            </div>
            <!-- Text Area for Post Content -->
            <div>
                <label for="post-content">Content</label>
                <textarea id="post-content" class="input__field" name="content" rows="10" cols="100" required></textarea>
            </div>
            <!-- Category Dropdown -->
            <div>
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
            <button class="save__btn" type="submit">Add Post</button>
        </form>
    </div>
</div>
