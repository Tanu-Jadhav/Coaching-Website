<?php
include("../config/db.php");

$message = "";
$type = ""; // success or error

if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // VALIDATION
    if(empty($name) || empty($email) || empty($password)){
        $message = "All fields are required!";
        $type = "error";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $message = "Invalid email format!";
        $type = "error";
    }
    else{
        // CHECK EMAIL EXISTS
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

        if(mysqli_num_rows($check) > 0){
            $message = "Email already registered!";
            $type = "error";
        } else {
            // INSERT USER
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $insert = mysqli_query($conn, "INSERT INTO users(name,email,password,role)
            VALUES('$name','$email','$hashed','user')");

            if($insert){
                $message = "Registration Successful!";
                $type = "success";
            } else {
                $message = "Something went wrong!";
                $type = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/register.css">
</head>
<body class="auth-body">

<div class="auth-box">
    <h2>Create Account</h2>

    <!-- MESSAGE -->
    <?php if($message){ ?>
        <p class="<?php echo $type; ?>"><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST">
        <input name="name" placeholder="Full Name">
        <input name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">

        <button name="register">Register</button>
    </form>

    <p class="link">
        Already have an account? <a href="login.php"> Login</a>
    </p>
</div>

</body>
</html>