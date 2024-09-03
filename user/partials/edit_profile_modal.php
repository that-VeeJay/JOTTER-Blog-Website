<div id="editProfileModal" class="edit-profile-modal">
    <div class="modal-content">
        <div>
            <span class="close-edit-modal modalClose">&times;</span>
            <h3>Edit Profile</h3>
        </div>
        <form class="update__form" action="../app/controllers/Profile.controller.php" method="POST" enctype="multipart/form-data">
            <div class="image">
                <label for="">Update profile picture</label>
                <input type="file" id="file-upload" name="file" class="profile__picture">
            </div>
            <div>
                <label for="">Update first name</label>
                <input type="text" class="input__field" name="first_name">
            </div>
            <div>
                <label for="">Update last name</label>
                <input type="text" class="input__field" name="last_name">
            </div>
            <div>
                <label for="">Update Bio</label>
                <textarea id="bio__text-area" class="input__field" maxlength="170" name="bio"></textarea>
                <div id="counter">0/170</div>
            </div>
            <button class="save__btn" type="submit">Save Changes</button>
        </form>
    </div>
</div>
