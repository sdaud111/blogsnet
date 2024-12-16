<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Resend Verification Email";
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                <?php
                if (isset($_SESSION['status'])) {
                ?>
                    <div class="alert alert-success">
                        <h5><?= $_SESSION['status']; ?></h5>
                    </div>
                <?php
                    unset($_SESSION['status']);
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h5>Resend Verification Email</h5>
                    </div>
                    <div class="card-body">
                        <form action="resend_email.php" method="POST">
                            <div class="form-group mb-3">
                                <input placeholder = "Email Address" type="email" name="email" class="form-control">
                            </div>
                            <!-- <div class="form-group">
                                <button type="submit" name="resend_vemail_btn" class="btn btn-primary">Send Email</button>
                            </div> -->
                            <input type="submit" name="resend_vemail_btn" class="btn-std">
                        </form>

                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>
