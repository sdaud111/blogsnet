<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('conn.php');

if(!$con) {
    $_SESSION['status'] = "Failed to establish connetion with database. Try Again Later!";
    header("Location: dashboard.php");
    exit(0);
}


if(isset($_POST['blog_content']) && $_SESSION['authenticated'] == true) {
    $current_user_id = $_SESSION['auth_user']['wid'];
    $title = mysqli_real_escape_string($con,$_POST['blog_title']);
    $c = $_POST['blog_content'];
    $content = mysqli_real_escape_string($con,$c);
    $submit_query = "INSERT INTO blog(uid, btitle, bcontent) VALUES($current_user_id,'$title','$content')";
    $submit_query_run = mysqli_query($con,$submit_query);
    if($submit_query_run) {
        $_SESSION['status'] = "Blog posted!";
        header("Location: explore.php");
        exit(0);
        // echo 'success';
    } else {
        $_SESSION['status'] = "Blog is too long! Try Again!";
        header("Location: dashboard.php");
        exit(0);
        // echo 'failure';
    }
}

?>