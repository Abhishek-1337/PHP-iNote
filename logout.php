<?php
    session_start();
    session_unset();
    session_destroy();

    header("location: /cwr/php/Login/login.php");
    exit;
?>