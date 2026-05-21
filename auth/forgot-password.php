<?php
include("../config/db.php");

if(isset($_POST['submit'])){
    $email = $_POST['email'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($query) > 0){
        echo "Reset link sent (demo)";
    } else {
        echo "Email not found";
    }
}
?>

<form method="POST">
    <input type="email" name="email" placeholder="Enter email">
    <button name="submit">Send Reset Link</button>
</form>