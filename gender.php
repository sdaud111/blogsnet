<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('conn.php');  // Include the connection file

if (!isset($_SESSION['auth_user']['wgender'])) {
    $_SESSION['auth_user']['wgender'] = 'MALE';
}

if (isset($_POST['toggle_gender'])) {
    // Toggle gender between 'MALE' and 'FEMALE'
    if ($_SESSION['auth_user']['wgender'] == 'MALE') {
        $_SESSION['auth_user']['wgender'] = 'FEMALE';
    } else {
        $_SESSION['auth_user']['wgender'] = 'MALE';
    }

    // Update the gender in the database
    $uid = $_SESSION['auth_user']['wid'];  
    $gender = $_SESSION['auth_user']['wgender'];

    // Check if a record for this user exists in the gender table
    $check_query = "SELECT * FROM gender WHERE uid = '$uid'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Record exists, update the gender
        $update_query = "UPDATE gender SET gender = '$gender' WHERE uid = '$uid'";
        mysqli_query($con, $update_query);
    } else {
        // Record does not exist, insert a new record
        $insert_query = "INSERT INTO gender (uid, gender) VALUES ('$uid', '$gender')";
        mysqli_query($con, $insert_query);
    }
}

header("Location: dashboard.php");
exit();
?>
