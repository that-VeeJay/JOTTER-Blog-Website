// Password Visibility Toggle
document.addEventListener('DOMContentLoaded', function() {
    let eyeIcons = document.querySelectorAll(".toggle__icon");
    let passwordInputs = document.querySelectorAll("input[type='password']");

    eyeIcons.forEach(function(eyeIcon, index) {
        eyeIcon.addEventListener("click", function() {
            if (passwordInputs[index].type === "password") {
                passwordInputs[index].type = "text";
                eyeIcon.src = "assets/icons/hidden.png";
            } else {
                passwordInputs[index].type = "password";
                eyeIcon.src = "assets/icons/eye.png";
            }
        })
    })
})
