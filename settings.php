<?php
include("../config/db.php");
session_start();

// ✅ Auth check
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ CSRF Token
if(empty($_SESSION['token'])){
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

// ✅ Fetch user
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if(!$user){
    die("User not found");
}


// ==========================
// ✅ HANDLE AJAX REQUESTS
// ==========================

// PROFILE UPDATE
if(isset($_POST['update_profile'])){
    
    if($_POST['token'] !== $_SESSION['token']){
        echo "csrf_error";
        exit();
    }

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $course = trim($_POST['course']);
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = trim($_POST['address']);

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, course=?, gender=?, dob=?, address=? WHERE id=?");
    $stmt->bind_param("sssssssi", $name, $email, $phone, $course, $gender, $dob, $address, $user_id);
    
    if($stmt->execute()){
        echo "profile_success";
    } else {
        echo "profile_error";
    }
    exit();
}


// PASSWORD CHANGE
if(isset($_POST['change_password'])){

    if(password_verify($_POST['old_password'], $user['password'])){
        
        $newPass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $newPass, $user_id);

        if($stmt->execute()){
            echo "pass_success";
        } else {
            echo "pass_error";
        }

    } else {
        echo "wrong_password";
    }
    exit();
}


// IMAGE UPLOAD
if(isset($_POST['upload_image'])){

    if(!empty($_FILES['image']['name'])){
        
        $img = time().'_'.basename($_FILES['image']['name']);
        $target = "../uploads/images/".$img;

        if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
            
            $stmt = $conn->prepare("UPDATE users SET image=? WHERE id=?");
            $stmt->bind_param("si", $img, $user_id);
            $stmt->execute();

            echo "image_success";
        } else {
            echo "image_error";
        }
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Account Settings</title>
<meta name="description" content="Manage your account settings">

<link rel="stylesheet" href="../assets/css/settings.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<div class="settings-container">

<h2><i class="fa fa-user-cog"></i> Account Settings</h2>

<!-- PROFILE IMAGE -->
<div class="card center">
    <img src="../uploads/images/<?= $user['image'] ?? 'default.png' ?>" class="profile-img">

    <input type="file" name="image">
</div>

<!-- PROFILE FORM -->
<div class="card">
<h3>Profile Information</h3>

<form id="profileForm">
<input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">

<div class="grid">

<input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" placeholder="Full Name" required>
<input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Email" required>
<input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" placeholder="Phone">
<input type="text" name="course" value="<?= htmlspecialchars($user['course']) ?>" placeholder="Course">

<select name="gender">
<option value="">Gender</option>
<option value="Male" <?= $user['gender']=='Male'?'selected':'' ?>>Male</option>
<option value="Female" <?= $user['gender']=='Female'?'selected':'' ?>>Female</option>
</select>

<input type="date" name="dob" value="<?= $user['dob'] ?>">

<textarea name="address" placeholder="Address"><?= htmlspecialchars($user['address']) ?></textarea>

</div>

<button type="submit" name="update_profile" class="btn">Save Changes</button>
</form>
</div>

<!-- PASSWORD -->
<div class="card">
<h3>Change Password</h3>

<form id="passwordForm">

<input type="password" name="old_password" placeholder="Old Password" required>

<input type="password" name="new_password" placeholder="New Password" required>
<small id="passStrength"></small>

<button type="submit" name="change_password" class="btn danger">Update Password</button>
</form>
</div>

</div>

<!--  ==========js================ -->
<script>  
// ===============================
// ✅ TOAST NOTIFICATION
// ===============================
function showToast(message, type = "success") {
    const toast = document.createElement("div");
    toast.className = `toast ${type}`;
    toast.innerText = message;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}


// ===============================
// ✅ PROFILE UPDATE (AJAX)
// ===============================
const profileForm = document.getElementById("profileForm");

if (profileForm) {
    profileForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch("settings.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            showToast("Profile updated successfully");
        })
        .catch(() => {
            showToast("Something went wrong!", "error");
        });
    });
}


// ===============================
// ✅ PASSWORD CHANGE (AJAX)
// ===============================
const passwordForm = document.getElementById("passwordForm");

if (passwordForm) {
    passwordForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch("settings.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            showToast("Password changed successfully");
            passwordForm.reset();
        })
        .catch(() => {
            showToast("Error updating password", "error");
        });
    });
}


// ===============================
// ✅ IMAGE UPLOAD + PREVIEW
// ===============================
const imageInput = document.querySelector("input[name='image']");
const profileImg = document.querySelector(".profile-img");

if (imageInput && profileImg) {
    imageInput.addEventListener("change", function (e) {

        const file = e.target.files[0];

        if (file) {
            // Preview
            const reader = new FileReader();
            reader.onload = function () {
                profileImg.src = reader.result;
            };
            reader.readAsDataURL(file);

            // Upload instantly (AJAX)
            const formData = new FormData();
            formData.append("image", file);
            formData.append("upload_image", true);

            fetch("settings.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(() => {
                showToast("Profile image updated");
            })
            .catch(() => {
                showToast("Image upload failed", "error");
            });
        }
    });
}


// ===============================
// ✅ PASSWORD STRENGTH CHECK
// ===============================
const passwordInput = document.querySelector("input[name='new_password']");
const strengthText = document.getElementById("passStrength");

if (passwordInput && strengthText) {
    passwordInput.addEventListener("input", function () {
        const val = passwordInput.value;

        let strength = "Weak";
        let color = "red";

        if (val.length >= 8 && /[A-Z]/.test(val) && /[0-9]/.test(val) && /[^A-Za-z0-9]/.test(val)) {
            strength = "Strong";
            color = "green";
        } else if (val.length >= 6) {
            strength = "Medium";
            color = "orange";
        }

        strengthText.innerText = `Strength: ${strength}`;
        strengthText.style.color = color;
    });
}


// ===============================
// ✅ OPTIONAL: AUTO HIDE ALERTS
// ===============================
const alerts = document.querySelectorAll(".success, .error");

alerts.forEach(alert => {
    setTimeout(() => {
        alert.style.display = "none";
    }, 3000);
});
</script>
</body>
</html>