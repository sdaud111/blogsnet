<?php
session_start();  

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    $_SESSION['status'] = "Please Log In to get access to the dashboard!";
    header("Location: login.php");  
    exit(0);  
}

?>