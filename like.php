<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start(); 
}
include("conn.php");

$uid = $_SESSION['auth_user']['wid']; 
if (isset($_POST['blog_id'])) {
    $blog_id = mysqli_real_escape_string($con, $_POST['blog_id']);

    $check_query = "SELECT * FROM blog_like WHERE bid = '$blog_id' AND uid = '$uid'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $delete_query = "DELETE FROM blog_like WHERE bid = '$blog_id' AND uid = '$uid'";
        if (mysqli_query($con, $delete_query)) {
            header("Location: blog.php?bid=$blog_id");
            exit();  
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        $insert_query = "INSERT INTO blog_like (bid, uid) VALUES ('$blog_id', '$uid')";
        if (mysqli_query($con, $insert_query)) {
            header("Location: blog.php?bid=$blog_id");
            exit(); 
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}
?>
