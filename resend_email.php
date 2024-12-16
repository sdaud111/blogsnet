<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("conn.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function resendemail_verify($name,$email,$verification_token) {
    
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'blolforblogscom@gmail.com';
        $mail->Password = 'jqlo snlw zdfc mson';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('blolforblogscom@gmail.com', 'Blol.com');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Resend Email Verification From Blol.com";

        // Verification email body with token from session
        $email_template = "
            <h2>You have registered with Blol.com</h2>
            <h5>Verify your email address to log in with the given link</h5>
            <br/><br/>
            <a href='http://localhost:3000/verify_email.php?token=$verification_token'>Click Me</a>
        ";

        $mail->Body = $email_template;

        // Send email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


if(isset($_POST['resend_vemail_btn'])) {
    if(!empty(trim($_POST['email']))) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $checkemail_query = "SELECT * FROM users WHERE uemail = '$email' LIMIT 1";
        $checkemail_query_run = mysqli_query($con, $checkemail_query);
        if(mysqli_num_rows($checkemail_query_run) > 0) {
            $row = mysqli_fetch_array($checkemail_query_run);
            if($row['uverification_status'] == 0) {
                $name = $row['uname'];
                $email = $row['uemail'];
                $verification_token = $row['uverification_token'];
                resendemail_verify($name,$email,$verification_token);
                $_SESSION['status'] = "Verification email has been sent to your email address!";
                header("Location: login.php");
                exit(0);
            } else {
                $_SESSION['status'] = "Email Already Verified. Please Log In!";
                header("Location: login.php");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "No such account exists. Sign In Now!";
            header("Location: signin.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "All fields are mandatory!";
        header("Location: resend_verification_email.php");
        exit(0);
    }
}
?>