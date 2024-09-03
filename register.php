<?php
$title = 'Register';

require __DIR__ . '/templates/head.php';
require __DIR__ . '/helpers/auth_helper.php';

initializeSession();
redirectUserBasedOnSession();
$userInputs = getSessionUserInput();
?>

<body>
    <div class="register__card">
        <div class="register__card--header">REGISTER</div>
        <hr>

        <div id="message"></div>

        <form id="registerForm">
            <div class="input__group">
                <img class="input__group--icon" src="assets/icons/user.png" alt="">
                <input type="text" id="first_name" placeholder="First Name" name="first_name" value="<?= $userInputs['first_name'] ?? ''; ?>">
            </div>

            <div class="input__group">
                <img class="input__group--icon" src="assets/icons/user.png" alt="">
                <input type="text" id="last_name" placeholder="Last Name" name="last_name" value="<?= $userInputs['last_name'] ?? ''; ?>">
            </div>

            <div class="input__group">
                <img class="input__group--icon" src="assets/icons/email.png" alt="">
                <input type="email" id="email" placeholder="Email" name="email" value="<?= $userInputs['email'] ?? ''; ?>">
            </div>

            <div class="input__group">
                <img class="input__group--icon" src="assets/icons/padlock.png" alt="">
                <input type="password" id="password" placeholder="Password" name="password">
                <img class="toggle__icon" src="assets/icons/eye.png" alt="">
            </div>

            <div class="input__group">
                <img class="input__group--icon" src="assets/icons/padlock.png" alt="">
                <input type="password" id="confirm_password" placeholder="Confirm Password" name="confirm_password">
                <img class="toggle__icon" src="assets/icons/eye.png" alt="">
            </div>

            <input class="register__card--button" id="submit" type="submit" value="SUBMIT"></input>
            <div class="login__option">Already a member? <a href="login.php">Login</a></div>
        </form>
    </div>

    <script>
        // AJAX REQUEST
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('registerForm');
            const msg = document.getElementById('message');

            form.addEventListener('submit', registerUser);

            async function registerUser(event) {
                event.preventDefault();

                const params = {
                    first_name: form.first_name.value,
                    last_name: form.last_name.value,
                    email: form.email.value,
                    password: form.password.value,
                    confirm_password: form.confirm_password.value,
                };

                fetch('./app/controllers/Register.controller.php', {
                        method: 'POST',
                        headers: {
                            'Content-type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams(params).toString()
                    })
                    .then(response => response.text())
                    .then(data => {
                        msg.classList.remove('success__message', 'failed__message');

                        if (data.includes('successful')) {
                            msg.classList.add('success__message');
                        } else {
                            msg.classList.add('failed__message');
                        }
                        msg.textContent = data;
                    })
            }
        })
    </script>
</body>

</html>
