<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Log In to ";
include('includes/header.php');
include('includes/navbar.php');

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true) {
    $_SESSION['status'] = "You are already logged in!";
    header("Location: dashboard.php");  
    exit(0);  
}
?>

<div class="main-div">
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="login-card">
                            <?php
                            if (isset($_SESSION['status'])) {
                            ?>
                                <div class="alert alert-success">
                                    <h5 style="display: inline;"><?= $_SESSION['status']; ?></h5>
                                </div>
                            <?php
                                unset($_SESSION['status']);
                            }
                            ?>
                        <h2>Login To The Website</h2>
                        <form method="POST" action="authlogin.php">
                            <div class="form-group">
                                <input type="email" placeholder="Email Address" name="email" required>
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="Password" name="password" required>
                            </div>
                            <input type="submit" name="login_btn" class="btn-std">
                        </form>
                        <div class="verification-resend">
                            <h6>Did Not Receive Verification Email? <a href="resend_vemail.php">Resend</a></h6>
                            <!-- <p>Don't Have an Account? <a href="signin.php">Sign In!</a></p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>
