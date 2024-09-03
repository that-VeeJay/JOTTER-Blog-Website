document.addEventListener('DOMContentLoaded', function() {
    let navbarProfile = document.querySelector(".navbar__profile");
    let subMenu = document.querySelector(".sub__menu");
    let burgerMenu = document.querySelector(".bi-list");

    // Toggle submenu visibility on profile click
    navbarProfile.addEventListener("click", function(event) {
        event.stopPropagation();
        subMenu.classList.toggle("sub__menu--toggle");
    });

    // Toggle burger menu icon
    burgerMenu.addEventListener("click", function(event) {
        event.stopPropagation();
        burgerMenu.classList.toggle("bi-x-lg");
    });

    // Hide submenu when clicking outside
    document.addEventListener("click", function(event) {
        if (!navbarProfile.contains(event.target) && !subMenu.contains(event.target)) {
            subMenu.classList.remove("sub__menu--toggle");
        }
    });
});
