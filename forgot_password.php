<?php
$title = 'Password Recovery';
require 'templates/head.php'
?>

<body>
    <div class="register__card">
        <div class="register__card--header">Password Recovery</div>
        <hr>
        <div class="forgot__password--text">Enter your email and we'll send you a link to get back into your account.</div>
        <form action="">
            <div class="input__group">
                <img class="input__group--icon" src="assets/icons/email.png" alt="">
                <input type="email" placeholder="Email">
            </div>
            <button class="register__card--button">SUBMIT</button>
            <div class="login__option">Back to<a href="login.php"> Login.</a></div>
        </form>
    </div>
</body>

</html>
