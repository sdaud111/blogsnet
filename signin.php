<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Sign In to ";
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <h2>Sign In</h2>
                    <div class="pic-container">
                        <h3>Add a picture?</h3>
                        <!-- File input to select an image -->
                        <input type="file" name="profile-pic" id="pic" accept="image/*" onchange="showPreview(event);">

                        <!-- Profile picture preview box -->
                        <div class="preview-box" id="previewBox"></div>
                    </div>
                    <div class="alert">
                        <?php 
                        if(isset($_SESSION['status']))
                        {
                            echo "<h4>".$_SESSION['status']."</h4>";
                            unset($_SESSION['status']);
                        }
                        ?>
                    </div>
                    <form method="POST" action="auth.php">
                        <div class="form-group">
                            <input type="text" placeholder="Name" name="name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" placeholder="Email Address" name="email" required>
                        </div>
                        <div class="form-group">
                            <input type="phone" placeholder="Phone Number (Optional)" name="phone">
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Password" name="password" id="password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Confirm Password" name="confirm_password" id="confirm_password" onkeyup="checkPasswordMatch();" required>
                        </div>
                        <div class="form-group">
                            <small id="passwordMessage"></small>
                        </div>
                        <input type="submit" name="signin_btn" class="btn-std" id="signin_btn" disabled>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/passwordCheck.js"></script>
<script>
    function showPreview(event) {
        const file = event.target.files[0];
        const previewBox = document.getElementById('previewBox');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Set the background image of the box and ensure it fits
                previewBox.style.backgroundImage = `url(${e.target.result})`;
                previewBox.style.backgroundSize = 'cover'; // Scale the image to cover the box
                previewBox.style.backgroundPosition = 'center'; // Center the image within the box
                previewBox.style.backgroundRepeat = 'no-repeat'; // Prevent repeating the image
            };
            reader.readAsDataURL(file);
        }
    }
</script>

<?php include('includes/footer.php')?>
