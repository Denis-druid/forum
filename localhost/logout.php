<?php
    setcookie("user_email", $user_email , time() - 36000);
    setcookie("user_password", $user_password, time() - 36000);
    header('Location:/index.php');