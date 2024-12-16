<?php 
include("includes/header.php");
include("includes/navbar.php");
include("conn.php");

$query = "SELECT * FROM FAQ";
$query_run = mysqli_query($con, $query);
?>

<div class="main-div">
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="faq-card">
                        <h2>Frequently Asked Questions</h2>
                        <div class="faq-item">
                         <h3>I cannot recieve my verification email? What do i do?</h3>
                         <p>If you cannot recieve your verification email, either you have provided an incorrect email address or you have provided the correct email address but the mail didnt reach you. In that case go this page to resend email to your email address <a href="resend_vemail.php">here</a></p>
                        </div>
                        <?php
                                while ($row = mysqli_fetch_assoc($query_run)) {
                                    $fquestion = isset($row['fquestion']) ? htmlspecialchars($row['fquestion']) : 'No question provided';
                                    $fanswer = isset($row['fanswer']) ? htmlspecialchars($row['fanswer']) : 'No answer provided';

                                    echo '<div class="faq-item">';
                                    echo '<h3>' . $fquestion . '</h3>';
                                    echo '<p>' . $fanswer . '</p>';
                                    echo '</div>';
                                }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include("includes/footer.php");
?>
