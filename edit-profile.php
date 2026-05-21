<?php
include("../config/db.php");
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$message = "";

// Update
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $course = $_POST['course'];
    $qualification = $_POST['qualification'];
    $address = $_POST['address'];

    // 📷 Image Upload
    if(!empty($_FILES['photo']['name'])){
        $photo = time()."_".$_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$photo);
    } else {
        $photo = $user['photo'];
    }

    $stmt = $conn->prepare("UPDATE users SET name=?, phone=?, dob=?, gender=?, course=?, qualification=?, address=?, photo=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $name, $phone, $dob, $gender, $course, $qualification, $address, $photo, $user_id);

    if($stmt->execute()){
        $message = "Profile Updated Successfully!";
    } else {
        $message = "Error updating profile!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile</title>

<link rel="stylesheet" href="../assets/css/edit-profile.css">
</head>

<body>

<div class="container">

    <h2>Edit Profile</h2>

    <?php if($message){ ?>
    <div class="toast"><?php echo $message; ?></div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">

    <input type="text" name="name" id="name" value="<?= $user['name'] ?>" placeholder="Full Name" required>

    <input type="text" name="phone" id="phone" value="<?= $user['phone'] ?>" placeholder="Phone Number">

    <input type="date" name="dob" value="<?= $user['dob'] ?>">

    <select name="gender">
        <option value="">Select Gender</option>
        <option <?= $user['gender']=='Male'?'selected':'' ?>>Male</option>
        <option <?= $user['gender']=='Female'?'selected':'' ?>>Female</option>
    </select>

    <input type="text" name="course" value="<?= $user['course'] ?>" placeholder="Course">

    <input type="text" name="qualification" value="<?= $user['qualification'] ?>" placeholder="Qualification">

    <textarea name="address" placeholder="Address"><?= $user['address'] ?></textarea>

    <!-- Image Preview -->
    <div class="img-box">
        <img id="preview" src="../uploads/images/<?= $user['photo'] ?>" width="100">
    </div>

    <input type="file" name="photo" onchange="previewImage(event)">

    <button id="btn" name="update">Update Profile</button>

</form>

</div>

<script>

// 🔥 Image Preview
function previewImage(event){
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('preview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

// 🔥 Form Validation
function validateForm(){
    let name = document.getElementById("name").value.trim();
    let phone = document.getElementById("phone").value.trim();

    if(name.length < 3){
        alert("Name must be at least 3 characters");
        return false;
    }

    if(phone && phone.length != 10){
        alert("Phone must be 10 digits");
        return false;
    }

    document.getElementById("btn").innerText = "Updating...";
    document.getElementById("btn").disabled = true;

    return true;
}

// 🔥 Toast Auto Hide
setTimeout(() => {
    let toast = document.querySelector(".toast");
    if(toast){
        toast.style.opacity = "0";
    }
}, 3000);

</script>
</body>
</html>