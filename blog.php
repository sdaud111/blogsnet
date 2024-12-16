<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("conn.php");
if (isset($_GET['bid'])) {
    $bid = mysqli_real_escape_string($con, $_GET['bid']);
    $query = "SELECT U.uname, B.bid, B.uid, B.btitle, B.bcontent, B.bcreated_at
              FROM blog AS B
              JOIN users AS U
              ON B.uid = U.uid
              WHERE B.bid = '$bid'
              LIMIT 1";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_assoc($query_run);
        $title = $row['btitle'];
        $content = $row['bcontent'];
        $meta = [
            'created_at' => $row['bcreated_at'],
            'name' => $row['uname'],
        ];
    } else {
        echo "Invalid blog ID.";
        exit;
    }
} else {
    echo "No blog ID provided.";
    exit;
}

include("includes/blogheader.php");
include("includes/navbar.php");
?>

<div class="blog-page">
    <div class="blog-card">
        <?php 
        include("blog/blog_title.php");
        ?>
        <div class="content"><?php echo html_entity_decode($content); ?></div>
        <?php 
        include("blog/comments_sect.php");
        ?>
        </div>
    </div>
</div>
