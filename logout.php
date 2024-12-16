<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION['authenticated']);
unset($_SESSION['auth_user']);
$_SESSION['status'] = "Logged Out Successfully!";
header("Location: login.php");
?>