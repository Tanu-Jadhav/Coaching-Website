<?php
include("../config/db.php");

session_start();

// ✅ CREATE TOKEN
if(empty($_SESSION['token'])){
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

// 🔐 check login
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_SESSION['user_id'];

// ✅ SECURE USER FETCH
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

// ❌ If user not found → logout
if(!$userData){
    session_destroy();
    header("Location: ../auth/login.php");
    exit();
}

// 🔐 ROLE CHECK (ADMIN ONLY)
if($userData['role'] !== 'admin'){
    echo "Access Denied";
    exit();
}

// ✅ FETCH USERS LIST
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

<!-- ✅ SEO -->
<title>User Management | Admin Panel</title>
<meta name="description" content="Manage users in admin dashboard">

<link rel="stylesheet" href="../assets/css/user.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<div class="dashboard">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2 class="logo">Admin</h2>

        <ul>
            <li><a href="../admin/dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="active"><a href="user.php"><i class="fa fa-users"></i> Users</a></li>
            <li><a href="../pages/courses.php"><i class="fa fa-book"></i> Courses</a></li>
            <li><a href="../pages/view-enquiry.php"><i class="fa fa-envelope"></i> Enquiries</a></li>
        </ul>
    </aside>

    <!-- Main -->
    <main class="main">

        <!-- Topbar -->
        <div class="topbar">
            <h1>Users Management</h1>

        <div class="top-right">

            <!-- 🔔 Notification -->
            <div class="notification">

    <div class="bell" id="bellBtn">
        <i class="fa fa-bell"></i>
        <span class="badges" id="notiCount">0</span>
    </div>

    <div class="noti-dropdown" id="notiMenu">
        <div class="noti-header">
            <h4>Notifications</h4>
        </div>

        <div id="notiList"></div>

        <div class="noti-footer">
            <a href="../api/all-notifications.php">View All</a>
        </div>
    </div>

</div>

            <!-- PROFILE -->
            <div class="profile">
                <?php
                    $photo = !empty($userData['photo']) ? $userData['photo'] : 'default.png';
                ?>

                <img src="../uploads/images/<?php echo $photo; ?>" id="profileBtn"
                onerror="this.src='../uploads/images/default.png'">

                <div class="dropdown" id="dropdownMenu">
                    <label class="upload-option">
                        <i class="fa fa-image"></i> Upload Photo
                        <input type="file" id="uploadPhoto" hidden>
                    </label>

                    <a href="../auth/profile.php"><i class="fa fa-user"></i> Profile</a>
                    <a href="javascript:void(0)" id="darkToggle">
                         <i class="fa fa-moon"></i> Dark Mode
                    </a>
                    <a href="../auth/settings.php"><i class="fa fa-cog"></i> Settings</a>
                    <a href="../auth/logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            </div>

        </div>
    </div>

        <!-- Content -->
        <div class="content">

            <div class="card">

                <div class="card-header">
                    <h2>All Users</h2>
                    <a href="../admin-actions/add-user.php" class="btn">+ Add User</a>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while($row = $users->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><span class="badge <?= $row['role']; ?>">
                                <?= htmlspecialchars($row['role']); ?></span></td>
                                <td>
                                    <a href="../admin-actions/edit-user.php?id=<?= (int)$row['id']; ?>" class="edit">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form method="POST" action="../admin-actions/delete-user.php" style="display:inline;">
    
                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
    
                                            <!-- ✅ CSRF TOKEN HERE -->
                                        <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">

                                        <button type="submit" class="delete" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash"></i>
                                         </button>

                                    </form>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>

            </div>

        </div>

    </main>

</div>

<!-- JS -->
<script>

// PROFILE DROPDOWN
document.getElementById("profileBtn").onclick = function(){
    let menu = document.getElementById("dropdownMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
};

// DARK MODE
const darkBtn = document.getElementById("darkToggle");

darkBtn.addEventListener("click", function(){

    document.body.classList.toggle("dark");

    let icon = this.querySelector("i");

    if(document.body.classList.contains("dark")){
        localStorage.setItem("mode","dark");
        icon.classList.remove("fa-moon");
        icon.classList.add("fa-sun");
    } else {
        localStorage.setItem("mode","light");
        icon.classList.remove("fa-sun");
        icon.classList.add("fa-moon");
    }

});

// LOAD MODE
window.addEventListener("load", function(){
    let mode = localStorage.getItem("mode");

    if(mode === "dark"){
        document.body.classList.add("dark");
    }
});


// 🔥 NOTIFICATION SYSTEM
const bell = document.getElementById("bellBtn");
const menu = document.getElementById("notiMenu");
const list = document.getElementById("notiList");
const count = document.getElementById("notiCount");

// 🔊 sound
const sound = new Audio("uploads/notify.mp3");

// toggle
bell.onclick = (e) => {
    e.stopPropagation();
    menu.classList.toggle("show");
};

// close outside
document.addEventListener("click", (e) => {
    if (!bell.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove("show");
    }
});

let lastCount = 0;

// load notifications
function loadNotifications(){
    fetch("../api/fetch-notifications.php")
    .then(res => res.json())
    .then(data => {

        list.innerHTML = "";
        count.innerText = data.length;

        // 🔔 play sound if new notification
        if(data.length > lastCount){
            sound.play();
        }
        lastCount = data.length;

        data.forEach(n => {

            let icon = "fa-bell";
            if(n.type === "user") icon = "fa-user";
            if(n.type === "enquiry") icon = "fa-envelope";
            if(n.type === "course") icon = "fa-book";

            list.innerHTML += `
            <div class="noti-item unread" onclick="markRead(${n.id})">
                <i class="fa ${icon}"></i>
                <div>
                    <p>${n.message}</p>
                    <span>${timeAgo(n.created_at)}</span>
                </div>
            </div>`;
        });

    });
}

// mark as read
function markRead(id){
    fetch("../api/mark-read.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "id=" + id
    })
    .then(() => loadNotifications());
}

// time ago
function timeAgo(time){
    const now = new Date();
    const past = new Date(time);
    const diff = Math.floor((now - past)/1000);

    if(diff < 60) return diff+" sec ago";
    if(diff < 3600) return Math.floor(diff/60)+" min ago";
    if(diff < 86400) return Math.floor(diff/3600)+" hr ago";
    return Math.floor(diff/86400)+" days ago";
}

// refresh every 3 sec (faster)
setInterval(loadNotifications, 3000);
loadNotifications();


// UPLOAD PROFILE
document.getElementById("uploadPhoto").addEventListener("change", function(){
    let file = this.files[0];
    if(!file) return;

    let formData = new FormData();
    formData.append("photo", file);

    document.getElementById("profileBtn").src = URL.createObjectURL(file);

    fetch("../admin-actions/upload-profile.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => console.log("Uploaded"));
});

</script>

</body>
</html>