<?php
include("../config/db.php");

$msg = "";

if(isset($_POST['reset'])){
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users 
        WHERE email='$email' AND otp='$otp'");

    if(mysqli_num_rows($check)){
        mysqli_query($conn, "UPDATE users 
            SET password='$pass', otp=NULL 
            WHERE email='$email'");

        $msg = "Password Updated!";
    } else {
        $msg = "Invalid OTP!";
    }
}
?>

<form method="POST">
    <input name="email" placeholder="Email" required>
    <input name="otp" placeholder="Enter OTP" required>
    <input type="password" name="password" placeholder="New Password" required>
    <button name="reset">Reset Password</button>
</form>

<p><?php echo $msg; ?></p>