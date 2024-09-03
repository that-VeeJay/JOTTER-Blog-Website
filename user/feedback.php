<?php
$title = 'Feedback';
$stylesheet = 'feedback';

require __DIR__ . '../../user/partials/head.php';
require __DIR__ . '../../user/partials/navbar.php';
?>

<body>
    <div class="fb__container">
        <div class="contact-box">
            <div class="left"></div>
            <div class="right">
                <h2>Feedback</h2>
                <input type="text" class="field" placeholder="Name">
                <input type="text" class="field" placeholder="Email">
                <input type="text" class="field" placeholder="Phone">
                <textarea placeholder="Message" class="field"></textarea>
                <button class="btn">Send</button>
            </div>
        </div>
    </div>
</body>

</html>
