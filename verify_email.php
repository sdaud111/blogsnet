<?php

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
    include('conn.php');                  // build connection

    if(isset($_GET['token']))                          // token is in URL
    {
        $token = $_GET['token'];                       // storing token
        $verify_query = "SELECT * FROM users WHERE uverification_token = '$token' LIMIT 1";   // getting the record 
        $verify_query_run = mysqli_query($con, $verify_query);

        if(mysqli_num_rows($verify_query_run) > 0) {                // record found
            $row = mysqli_fetch_array($verify_query_run);
            if($row['uverification_status'] == 0) {                        // not verified before
                $clicked_token = $row['uverification_token'];
                $update_query = "UPDATE users SET uverification_status = 1 WHERE uverification_token = '$clicked_token' LIMIT 1";
                $update_query_run = mysqli_query($con,$update_query);
                if($update_query_run) {
                    $_SESSION['status'] =  "Your account has been verified successfully.";
                    header("Location: login.php");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Verification Failed!";
                    header("Location: login.php");
                    exit(0);
                }
            } else {                                                // verified before
                $_SESSION['status'] =  "Email Already Verified. Please Log In!";
                header("Location: login.php");
                exit(0);
            }
        }
    } else {                                                        // token not in URL
        $_SESSION['status'] = "Not Allowed";
        header("Location: login.php");
        exit(0);
    }
?>

