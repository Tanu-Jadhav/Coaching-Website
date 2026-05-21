<?php
include("../config/db.php");
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

// Insert User
if(isset($_POST['submit'])){
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role  = mysqli_real_escape_string($conn, $_POST['role']);
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name, email, password, role) 
              VALUES ('$name','$email','$pass','$role')";

    if(mysqli_query($conn, $query)){
        header("Location: ../user-actions/user.php?success=1");
        exit();
    } else {
        $error = "Something went wrong!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add User</title>

<link rel="stylesheet" href="../assets/css/add-user.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<div class="dashboard">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2 class="logo">Admin</h2>

        <ul>
            <li><a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="active"><a href="user.php"><i class="fa fa-users"></i> Users</a></li>
            <li><a href="../pages/courses.php"><i class="fa fa-book"></i> Courses</a></li>
            <li><a href="../pages/enquiries.php"><i class="fa fa-envelope"></i> Enquiries</a></li>
            <li><a href="../auth/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Main -->
    <main class="main">

        <!-- Topbar -->
        <div class="topbar">
            <h1>Add New User</h1>
        </div>

        <!-- Content -->
        <div class="content">

            <div class="form-card">

                <h2>Create User</h2>

                <?php if(isset($error)) { ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php } ?>

                <form method="POST">

                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label>User Role</label>
                        <select name="role" required>
                            <option value="">Select Role</option>
                            <option value="admin">User</option>
                            <option value="student">Student</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn">
                            <i class="fa fa-plus"></i> Create User
                        </button>

                        <a href="../user-actions/user.php" class="btn cancel">Cancel</a>
                    </div>

                </form>

            </div>

        </div>

    </main>

</div>

</body>
</html>