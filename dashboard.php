<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("authenticated.php");
$page_title = "Dashboard - ";
include('includes/header.php');
include('includes/navbar.php');
include('conn.php');

$uid = $_SESSION['auth_user']['wid'];
$query = "SELECT * FROM gender WHERE uid = '$uid' LIMIT 1";
$query_run = mysqli_query($con,$query);
if($query_run) {
    $row = mysqli_fetch_assoc($query_run);
    $_SESSION['auth_user']['wgender'] = $row['gender'];
}
?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="main-div">
                    <div class="card profile-card">
                    <?php
                    if (isset($_SESSION['status'])) {
                        echo '<div class="alert alert-success"><h5>' . $_SESSION['status'] . '</h5></div>';
                        unset($_SESSION['status']);
                    }
                    ?>
                        <div class="card-header text-center">
                            <h4>Profile</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            if (!$_SESSION['authenticated']) {
                                echo '<div class="alert alert-danger"><h3>Login to get access</h3></div><hr>';
                            }
                            ?>

                            <div class="profile-info">
                                <div class="profile-pic">
                                    <form method="POST" action="gender.php">
                                        <button type="submit" name="toggle_gender" value="toggle" style="border: none; background: transparent; padding: 0;">
                                            <?php
                                            // Set the profile picture based on the gender
                                            $profilePic = 'prof.png'; // Default
                                            if ($_SESSION['auth_user']['wgender'] == 'MALE') {
                                                $profilePic = 'profile_man.png';
                                            } elseif ($_SESSION['auth_user']['wgender'] == 'FEMALE') {
                                                $profilePic = 'profile_woman.png';
                                            }
                                            ?>
                                            <img src="/assets/<?= $profilePic ?>" alt="Profile Picture" class="profile-img">
                                        </button>
                                    </form>
                                </div>
                                <div class="profile-details">
                                    <h3>User ID: <span class="s1"><?= $_SESSION['auth_user']['wid'] ?? 'N/A' ?></span></h3>
                                    <h3>Name: <span class="s2"><?= $_SESSION['auth_user']['wusername'] ?? 'N/A' ?></span></h3>
                                    <h3>Email: <span class="s3"><?= $_SESSION['auth_user']['wemail'] ?? 'N/A' ?></span></h3>
                                    <h3>Phone: <span class="s4"><?= $_SESSION['auth_user']['wphone'] ?? 'N/A' ?></span></h3>
                                    <h3>Gender: <span class="s5"><?= $_SESSION['auth_user']['wgender'] ?></span></h3>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
