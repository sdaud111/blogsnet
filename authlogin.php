<?php 
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }   
    include("conn.php");
    if(isset($_POST['login_btn'])) {            // login_btn clicked
        if(!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
            $email = mysqli_real_escape_string($con,$_POST['email']);
            $password = mysqli_real_escape_string($con,$_POST['password']);
            $login_query = "SELECT * FROM users WHERE uemail = '$email' AND upassword = '$password' LIMIT 1";
            $login_query_run = mysqli_query($con,$login_query);
            if(mysqli_num_rows($login_query_run) > 0) {
                $row = mysqli_fetch_array($login_query_run);
                if($row['uverification_status'] == 1) {
                    $uid = $row['uid'];
                    $query = "SELECT * FROM gender WHERE uid = '$uid' LIMIT 1";
                    $query_run = mysqli_query($con,$query);
                    $gender = mysqli_fetch_assoc($query_run);
                    $_SESSION['authenticated'] = true;
                    $_SESSION['auth_user'] = [
                        'wid' => $row['uid'],
                        'wusername' => $row['uname'],
                        'wphone' => $row['uphone'],
                        'wemail' => $row['uemail'],
                        'wgender' => $gender['gender']
                    ];
                    $_SESSION['status'] = "You are logged in successfully";
                    header("Location: dashboard.php");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Please verify your email address to log in";
                    header("Location: login.php");
                    exit(0);
                }
            } else {
                $basit_query = "SELECT * FROM users WHERE uemail = '$email' LIMIT 1";
                $basit_query_run = mysqli_query($con,$basit_query);
                if(mysqli_num_rows($basit_query_run) > 0) {
                    $_SESSION['status'] = "Invalid Email or Password";
                    header("Location: login.php");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Account Does Not Exist";
                    header("Location: signin.php");
                    exit(0);
                }
            }
        } else {
            $_SESSION['status'] = "All fields are mandatory! Try Again.";
            header("Location: login.php");
            exit(0);
        }
    }
?>


