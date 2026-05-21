<?php
include("../config/db.php");
session_start();

$errors = [];

// ===== CSRF TOKEN =====
if(empty($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ===== LOGIN ATTEMPT LIMIT =====
if(!isset($_SESSION['login_attempts'])){
    $_SESSION['login_attempts'] = 0;
}
if(!isset($_SESSION['last_attempt_time'])){
    $_SESSION['last_attempt_time'] = time();
}

if(isset($_POST['login'])){

    // CSRF CHECK
    if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']){
        die("Invalid CSRF token");
    }

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // LOCK AFTER 5 ATTEMPTS
    if($_SESSION['login_attempts'] >= 5){
        if(time() - $_SESSION['last_attempt_time'] < 30){
            $errors[] = "Too many attempts. Try again after 30 seconds.";
        } else {
            $_SESSION['login_attempts'] = 0;
        }
    }

    // VALIDATION
    if(empty($email)){
        $errors[] = "Email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Invalid email format";
    }

    if(empty($password)){
        $errors[] = "Password is required";
    }

    if(empty($errors)){

        $email = mysqli_real_escape_string($conn, $email);

        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

        if(mysqli_num_rows($query) == 0){

            $errors[] = "User not found";
            $_SESSION['login_attempts']++;
            $_SESSION['last_attempt_time'] = time();

        } else {

            $user = mysqli_fetch_assoc($query);

            if(!password_verify($password, $user['password'])){

                $errors[] = "Invalid password";
                $_SESSION['login_attempts']++;
                $_SESSION['last_attempt_time'] = time();

            } else {

                // SUCCESS LOGIN
$_SESSION['user_id'] = $user['id'];
$_SESSION['last_activity'] = time();
$_SESSION['login_attempts'] = 0;

// ✅ Redirect to enroll page if exists
if(isset($_SESSION['redirect_url'])){
    $redirect = $_SESSION['redirect_url'];
    unset($_SESSION['redirect_url']);
    header("Location: $redirect");
} else {
    header("Location: ../pages/index.php");
}
exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login | Coaching Management System</title>
<meta name="description" content="Secure login to access dashboard, courses, faculty and user management.">

<link rel="stylesheet" href="../assets/css/login.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<div class="login-container">

    <div class="login-box">

        <h1>Login</h1>
        <p class="sub-text">Access your account securely</p>

        <!-- ERROR -->
        <?php if(!empty($errors)){ ?>
            <div class="error-box">
                <ul>
                    <?php foreach($errors as $e){ ?>
                        <li><?= $e ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <form method="POST">

            <!-- CSRF -->
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <!-- EMAIL -->
            <div class="input-group">
                <input type="text" name="email" required value="<?= $email ?? '' ?>">
                <label>Email Address</label>
                <i class="fa fa-envelope"></i>
            </div>

            <!-- PASSWORD -->
            <div class="input-group">
                <input type="password" name="password" id="password" required>
                <label>Password</label>
                <i class="fa fa-lock"></i>

                <span class="toggle-pass" onclick="togglePassword()">
                    <i class="fa fa-eye"></i>
                </span>
            </div>

            <button name="login" class="login-btn">Login</button>

            <div class="register-text">
                <p>Don't have an account?</p>
                <a href="../auth/register.php">Register Here</a>
            </div>

        </form>

    </div>

</div>

<script>
function togglePassword(){
    const pass = document.getElementById("password");
    const icon = document.querySelector(".toggle-pass i");

    if(pass.type === "password"){
        pass.type = "text";
        icon.classList.replace("fa-eye","fa-eye-slash");
    } else {
        pass.type = "password";
        icon.classList.replace("fa-eye-slash","fa-eye");
    }
}
</script>

</body>
</html>