document.addEventListener('DOMContentLoaded', function() {

    // Edit Profile Modal
    const modal = document.getElementById('editProfileModal');
    const btn = document.getElementById('openEditBtn');
    const span = document.getElementsByClassName('close-edit-modal')[0];
    const textarea = document.getElementById('bio__text-area');
    const counter = document.getElementById('counter');

    // Add Post Modal
    const postModal = document.getElementById('addPostModal');
    const openBtn = document.getElementById('openAddPostBtn');
    const closeBtn = document.getElementsByClassName('modalClose')[0];
    const addClose = document.getElementById('add-close');

    // Edit Profile Function
    function updateCounter() {
        const maxLength = textarea.getAttribute("maxlength");
        const currentLength = textarea.value.length;
        counter.textContent = `${currentLength}/${maxLength}`;
    }

    btn.onclick = function() {
        modal.style.display = 'block';
    }

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        } else if (event.target == postModal) {
            postModal.style.display = 'none';
        }
    }
    updateCounter();
    textarea.addEventListener('input', updateCounter);

    // Add Post Function
    openBtn.onclick = function() {
        postModal.style.display = 'block'
    }

    closeBtn.onclick = function() {
        postModal.style.display = 'none'
    }

    addClose.onclick = function() {
        postModal.style.display = 'none'
    }


    window.onclick = function() {
        postModal.style.display = 'none';
    }

});
