<?php
include("../config/db.php");
session_start();

if(!isset($_SESSION['user_id'])){
        header("Location: ../auth/login.php");
    exit();
}

// Get ID
if(!isset($_GET['id'])){
    header("Location: ../user-actions/user.php");
    exit();
}

$id = (int) $_GET['id'];

// Fetch user
$result = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($result);

// Update User
if(isset($_POST['update'])){
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role  = mysqli_real_escape_string($conn, $_POST['role']);

    // Password optional
    if(!empty($_POST['password'])){
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE users SET name='$name', email='$email', password='$pass', role='$role' WHERE id='$id'";
    } else {
        $query = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id='$id'";
    }

    if(mysqli_query($conn, $query)){
        header("Location: ../user-actions/user.php?updated=1");
        exit();
    } else {
        $error = "Update failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="../assets/css/add-user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2 class="logo">Admin</h2>
        <ul>
            <li><a href="../admin/dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="active"><a href="../user-actions/user.php"><i class="fa fa-users"></i> Users</a></li>
            <li><a href="../auth/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Main -->
    <main class="main">

        <div class="topbar">
            <h1>Edit User</h1>
        </div>

        <div class="form-card">

            <h2>Update User</h2>

            <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

            <form method="POST">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>

                <div class="form-group">
                    <label>New Password (optional)</label>
                    <input type="password" name="password">
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role">
                        <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>User</option>
                        <option value="student" <?php if($user['role']=='student') echo 'selected'; ?>>Student</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" name="update" class="btn">
                        <i class="fa fa-save"></i> Update
                    </button>
                    <a href="user.php" class="btn cancel">Cancel</a>
                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>