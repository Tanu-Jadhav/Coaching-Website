<?php
include("../config/db.php");
session_start();

// 🔐 Auth check
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Secure query
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
if(!$stmt){
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile</title>

<link rel="stylesheet" href="../assets/css/profile.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<div class="layout">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Coaching</h2>

        <nav>
            <a href="../admin/dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
            <a href="profile.php" class="active"><i class="fa fa-user"></i> Profile</a>
            <a href="../pages/courses.php"><i class="fa fa-book"></i> Courses</a>
            <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <!-- Main -->
    <main class="main">

        <!-- Profile Header -->
        <div class="profile-header">

            <?php if(!empty($user['photo'])){ ?>
                <img src="../uploads/images/<?php echo $user['photo']; ?>" class="avatar-img">
            <?php } else { ?>
                <div class="avatar">
                    <?php echo strtoupper(substr($user['name'],0,2)); ?>
                </div>
            <?php } ?>

            <div>
                <h2><?php echo htmlspecialchars($user['name']); ?></h2>
                <span class="badge"><?php echo htmlspecialchars($user['role']); ?></span>
            </div>

        </div>

        <!-- Personal Info -->
        <h3>Personal Information</h3>

        <div class="grid">

            <div class="card">
                <label>Mobile Number</label>
                <p><?= $user['phone'] ?: '-' ?></p>
            </div>

            <div class="card">
                <label>Email</label>
                <p><?= htmlspecialchars($user['email']) ?></p>
            </div>

            <div class="card">
                <label>Date of Birth</label>
                <p><?= $user['dob'] ?: '-' ?></p>
            </div>

            <div class="card">
                <label>Gender</label>
                <p><?= $user['gender'] ?: '-' ?></p>
            </div>

            <div class="card">
                <label>Address</label>
                <p><?= $user['address'] ?: '-' ?></p>
            </div>

        </div>

        <!-- Academic Info -->
        <h3>Academic Information</h3>

        <div class="grid">

            <div class="card">
                <label>Course</label>
                <p><?= $user['course'] ?: '-' ?></p>
            </div>

            <div class="card">
                <label>Qualification</label>
                <p><?= $user['qualification'] ?: '-' ?></p>
            </div>

        </div>

        <!-- Button -->
        <div class="action">
            <a href="../admin-actions/edit-profile.php" class="btn">Edit Profile</a>
        </div>

    </main>

</div>

</body>
</html>