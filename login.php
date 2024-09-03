<?php
$title = 'Login';

require __DIR__ . '/templates/head.php';
require __DIR__ . '/helpers/auth_helper.php';

initializeSession();
redirectUserBasedOnSession();
$userEmail = getSessionEmail();
?>

<body>
    <div class="register__card">
        <div class="register__card--header">LOGIN</div>
        <hr>

        <div id="message"></div>

        <form id="loginForm">
            <div class="input__group">
                <img class="input__group--icon" src="assets/icons/email.png" alt="">
                <input type="text" id="email" placeholder="Email" name="email" value="<?= $userEmail; ?>">
            </div>
            <div class="input__group">
                <img class="input__group--icon" src="assets/icons/padlock.png" alt="">
                <input type="password" id="password" placeholder="Password" name="password">
                <img class="toggle__icon" src="assets/icons/eye.png" alt="">
            </div>

            <a class="forgot__password" href="forgot_password.php">Forgot password?</a>

            <input class="register__card--button" type="submit" value="LOGIN"></input>
            <div class="login__option">Not a member yer? <a href="register.php">Register</a></div>
        </form>
    </div>

    <script>
        // Ajax Request
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('loginForm');
            const msg = document.getElementById('message');

            form.addEventListener('submit', loginUser);

            async function loginUser(event) {
                event.preventDefault();

                const params = {
                    email: form.email.value,
                    password: form.password.value,
                };

                fetch('./app/controllers/Login.controller.php', {
                        method: 'POST',
                        headers: {
                            'Content-type': 'application/json'
                        },
                        body: JSON.stringify(params)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect;
                        } else {
                            msg.classList.add('failed__message');
                            msg.textContent = data.msg;
                        }
                    })
            }
        })
    </script>
</body>

</html>
