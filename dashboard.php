<?php
include("../config/db.php");
session_start();

$timeout = 900; // 15 minutes

if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)){
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php?msg=Session expired");
    exit();
}

$_SESSION['last_activity'] = time();

// 🔐 check login
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_SESSION['user_id'];

// USER DATA
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

// COUNTS
$enq = $conn->query("SELECT COUNT(*) as total FROM enquiries")->fetch_assoc()['total'];
$courses = $conn->query("SELECT COUNT(*) as total FROM courses")->fetch_assoc()['total'];
$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];


?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>COACHING</h2>

    <a href="../pages/view-enquiry.php"><i class="fas fa-envelope"></i> Enquiries</a>
    <a href="manage_courses.php"><i class="fas fa-book"></i> Courses</a>
    <a href="manage-faculty.php"><i class="fas fa-user"></i> Faculty</a>
    <a href="../pages/results.php"><i class="fas fa-trophy"></i> Results</a>
    <a href="../pages/gallery.php"><i class="fas fa-image"></i> Gallery</a>
    <a href="downloads.php"><i class="fas fa-download"></i> Downloads</a>
    <a href="../user-actions/user.php"><i class="fas fa-users"></i> Users</a>
</div>

<!-- MAIN -->
<div class="main">

<!-- TOPBAR -->
<div class="topbar">
        <h1> Dashboard</h1>

<div class="top-right">

<!-- 🔥 NEW NOTIFICATION SYSTEM -->
<div class="notification">

    <div class="bell" id="bellBtn">
        <i class="fa fa-bell"></i>
        <span class="badge" id="notiCount">0</span>
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

<!-- CARDS -->
<div class="stats">

<div class="kpi-card">
    <div class="kpi-left blue"><i class="fa fa-envelope"></i></div>
    <div class="kpi-content">
        <h2><?php echo $enq; ?></h2>
        <p>Total Enquiries</p>
    </div>
</div>

<div class="kpi-card-course">
    <div class="kpi-left green"><i class="fa fa-book"></i></div>
    <div class="kpi-content">
        <h2><?php echo $courses; ?></h2>
        <p>Total Courses</p>
    </div>
</div>

<div class="kpi-card-users">
    <div class="kpi-left gold"><i class="fa fa-users"></i></div>
    <div class="kpi-content">
        <h2><?php echo $users; ?></h2>
        <p>Total Users</p>
    </div>
</div>

</div>

<!-- CHARTS -->
<div class="charts">
    <div class="chart-box">
        <h3>Monthly Enquiries</h3>
        <canvas id="barChart"></canvas>
    </div>

    <div class="chart-box">
        <h3>Overview</h3>
        <canvas id="pieChart"></canvas>
    </div>
</div>

</div>

<script>

// PROFILE DROPDOWN
profileBtn.onclick = () => {
    dropdownMenu.style.display =
        dropdownMenu.style.display === "block" ? "none" : "block";
};

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

// CHARTS
new Chart(barChart, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr'],
        datasets: [{ data: [5,10,7,12] }]
    }
});

new Chart(pieChart, {
    type: 'doughnut',
    data: {
        labels: ['Enquiries','Courses','Users'],
        datasets: [{ data: [10,5,8] }]
    }
});

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

</script>

</body>
</html>