<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Explore";
include("includes/exploreheader.php");
include("includes/navbar.php");
include("conn.php");

$query = "SELECT * FROM blog ORDER BY bcreated_at DESC";
$query_run = mysqli_query($con, $query);

?> 
<div class="main-div">
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="blog-list">
                        <?php
                        if (isset($_SESSION['status'])) {
                            echo '<div class="alert alert-success"><h5>' . $_SESSION['status'] . '</h5></div>';
                            unset($_SESSION['status']);
                        }
                        ?>
                        <?php
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            $bid = $row['bid'];
                            $uid = $row['uid'];
                            $btitle = $row['btitle'];
                            $bcreated_at = $row['bcreated_at'];

                            $user_query = "SELECT uname FROM users WHERE uid = '$uid' LIMIT 1";
                            $user_query_run = mysqli_query($con, $user_query);
                            $user = mysqli_fetch_assoc($user_query_run);

                            $gender_query = "SELECT * FROM gender WHERE uid = '$uid' LIMIT 1";
                            $gender_query_run = mysqli_query($con,$gender_query);
                            $gender = mysqli_fetch_assoc($gender_query_run);

                            $like_query = "SELECT count(*) FROM blog_like WHERE bid = '$bid' LIMIT 1";
                            $like_query_run = mysqli_query($con,$like_query);
                            $likes = mysqli_fetch_assoc($like_query_run);

                            $comment_query = "SELECT count(*) FROM blog_comment WHERE bid = '$bid' LIMIT 1";
                            $comment_query_run = mysqli_query($con,$comment_query);
                            $comments = mysqli_fetch_assoc($comment_query_run);
                            if($gender['gender'] == 'MALE') {
                                $profilePic = 'profile_man.png';
                            } else {
                                $profilePic = 'profile_woman.png';
                            }
                        ?>
                        <a href="blog.php?bid=<?= htmlspecialchars($bid) ?>" class = "blog-card-link" style="text-decoration: none; color: inherit;">
                            <div class="blog-card">
                                <div class="pic">
                                    <img src="/assets/<?= $profilePic ?>" alt="Profile Picture">
                                </div>
                                <div class="blog-item">
                                    <h3><?= htmlspecialchars($btitle) ?></h3>
                                    <p>Posted By: <span class="poster1"><?= htmlspecialchars($user['uname'] ?? 'Unknown') ?></span></p>
                                    <p>Posted On: <span class="poster2"><?= htmlspecialchars($bcreated_at) ?></span></p>
                                    <div class="like-button-container">
                                        <button class="like-button">
                                            <span class="material-icons">thumb_up</span>
                                        </button>
                                        <span class="like-count"><?= $likes['count(*)'] ?></span>
                                    </div>
                                    <div class="comment-button-container">
                                        <button class="comment-button">
                                            <span class="material-icons">keyboard_alt</span>
                                        </button>
                                        <span class="comment-count"><?= $comments['count(*)'] ?></span> 
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php } ?>
                        <div class="blog-card">
                            <div class="pic">
                                <img src="/assets/profile_man.png" alt="Profile Picture">
                            </div>
                            <div class="blog-item">
                                <h3>Hello! Welcome to Blol.com. We'll help you get started. We will show you around!</h3>
                                <p>Posted By: <span class="poster1">Admin</span></p>
                                <p>Posted On: <span class="poster2">100 BC (probably)</span></p>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
include("includes/footer.php");
?>
