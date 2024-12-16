<?php
include("conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['reply-btn'])) {
    $parent_cid = $_POST['parent_cid'];
    $bid = $_POST['bid']; // Get the blog ID from the form
    $reply_comment = $_POST['reply_comment'];
    $uid = $_SESSION['auth_user']['wid'];

    $reply_comment = mysqli_real_escape_string($con, $reply_comment);

    $query = "INSERT INTO blog_comment (uid, bid, parent_cid, comment_text) 
              VALUES ('$uid', '$bid', '$parent_cid', '$reply_comment')";

    if (mysqli_query($con, $query)) {
        $_SESSION['status'] = "Reply added successfully!";
        header("Location: blog.php?bid=$bid"); // Redirect with blog ID
        exit(0);
    } else {
        $_SESSION['status'] = "Error adding reply.";
        header("Location: blog.php?bid=$bid"); // Redirect with blog ID
        exit(0);
    }
}
?>
