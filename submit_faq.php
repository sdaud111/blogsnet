<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('conn.php');

if (isset($_POST['faq_question']) && isset($_POST['faq_answer']) && $_SESSION['authenticated'] == true) {
    // Retrieve user ID from session
    $current_user_id = $_SESSION['auth_user']['wid'];

    // Sanitize inputs
    $question = mysqli_real_escape_string($con, $_POST['faq_question']);  // Question as plain text
    $answer = mysqli_real_escape_string($con, $_POST['faq_answer']);      // Answer as plain text

    // Insert the FAQ into the database
    $submit_query = "INSERT INTO faq(uid, fquestion, fanswer) VALUES($current_user_id, '$question', '$answer')";
    $submit_query_run = mysqli_query($con, $submit_query);

    if ($submit_query_run) {
        $_SESSION['status'] = "FAQ posted!";
        header("Location: dashboard.php");
        exit(0);
        // echo 'Success'; 
    } else {
        $_SESSION['status'] = "Could Not Submit FAQ. Try Again Later!";
        header("Location: dashboard.php");
        exit(0);
        // echo 'Failure';
    }
}
?>
