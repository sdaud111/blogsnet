<?php
include("conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['sub-comment'])) {
    $comment = trim($_POST['comment']); 
    if (!empty($comment)) {
        if (isset($_GET['bid'])) {
            $bid = mysqli_real_escape_string($con, $_GET['bid']);
            $uid = $_SESSION['auth_user']['wid']; 

            $query = "INSERT INTO blog_comment (uid, bid, comment_text) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'iis', $uid, $bid, $comment);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['status'] = "Commented Successfully!";
                header("Location: blog.php?bid=$bid");
                exit(0);
            } else {
                $_SESSION['status'] = "We had an error while saving your comment! Please try again!";
                header("Location: blog.php?bid=$bid");
                exit(0);
            }

            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['status'] = "Invalid Blog ID.";
            header("Location: blog.php?bid=$bid");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "No text in comment.";
        header("Location: blog.php?bid=$bid");
        exit(0);
    }
}
?>
