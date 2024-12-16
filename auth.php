<?php
session_start();
include('conn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendemail_verify($name, $email, $token) {

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
        $mail->Subject = "Email Verification From Blol.com";

        // Verification email body with token from session
        $email_template = "
            <h2>You have registered with Blol.com</h2>
            <h5>Verify your email address to log in with the given link</h5>
            <br/><br/>
            <a href='http://localhost:3000/verify_email.php?token=$token'>Click Me</a>
        ";

        $mail->Body = $email_template;

        // Send email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['signin_btn'])) {                    // button presses
    $name = $_POST['name'];                                      
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $token = md5(rand());

    // Check if email already exists in the database
    $check_email_query = "SELECT uemail FROM users WHERE uemail = '$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if (mysqli_num_rows($check_email_query_run) > 0) {
        $_SESSION['status'] = 'Email Address already exists. Try Again!';
        header('Location: signin.php');
        exit(0);
    } else {
        // Insert user data into the database
        $query = "INSERT INTO users (uname, uemail, uphone, upassword, uverification_token) 
                  VALUES ('$name', '$email', '$phone', '$password', '$token')";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $uid = mysqli_insert_id($con);
            $gender_query = "INSERT INTO gender (uid,gender) VALUES ('$uid','MALE')";
            mysqli_query($con,$gender_query);
            sendemail_verify($name, $email,$token);  
            $_SESSION['status'] = 'Sign In Successful! Verify Your Email Address';
            header('Location: signin.php');
            exit(0);
        } else {
            $_SESSION['status'] = 'Sign In Failed!';
            header('Location: signin.php');
            exit(0);
        }
    }
}
?>
