<?php
include("../config/db.php");
session_start();

// 🔐 LOGIN CHECK
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

// FETCH DATA
$result = mysqli_query($conn, "SELECT * FROM notifications ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- SEO -->
<title>All Notifications | Coaching Dashboard</title>
<meta name="description" content="View all system notifications including enquiries, user activity, and course updates.">
<meta name="keywords" content="notifications, dashboard alerts, user updates, enquiries">

<link rel="stylesheet" href="../assets/css/all-notifications.css">

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<div class="noti-container">

    <div class="noti-header">
        <h1>All Notifications</h1>
        <button onclick="markAll()" class="mark-btn">
            <i class="fa fa-check"></i> Mark All as Read
        </button>
    </div>

    <div class="noti-list">

        <?php while($n = mysqli_fetch_assoc($result)) { ?>

        <div class="noti-row <?php echo $n['is_read'] ? '' : 'unread'; ?>">

            <div class="icon">
                <i class="fa 
                <?php 
                    if($n['type']=="user") echo "fa-user";
                    elseif($n['type']=="enquiry") echo "fa-envelope";
                    elseif($n['type']=="course") echo "fa-book";
                    else echo "fa-bell";
                ?>"></i>
            </div>

            <div class="content">
                <p><?php echo htmlspecialchars($n['message']); ?></p>
                <span><?php echo $n['created_at']; ?></span>
            </div>

        </div>

        <?php } ?>

    </div>

</div>

<script>
function markAll(){
    fetch("mark-all-read.php")
    .then(()=>location.reload());
}
</script>

</body>
</html>