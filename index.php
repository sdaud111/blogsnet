<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Welcome to ";
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Login and Register to Blol.com</h4>
                <h4>To Explore Blogs From Around The World</h5>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php')?>