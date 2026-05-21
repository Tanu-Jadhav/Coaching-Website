<?php
include("../config/db.php");
session_start();

if(!isset($_SESSION['user_id'])){
    exit("Unauthorized");
}

$id = $_SESSION['user_id'];

if(isset($_FILES['photo'])){

    $file = $_FILES['photo']['name'];
    $tmp  = $_FILES['photo']['tmp_name'];

    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $newName = "user_" . $id . "_" . time() . "." . $ext;

    if(move_uploaded_file($tmp, "uploads/images/" . $newName)){

        // Update DB
        mysqli_query($conn, "UPDATE users SET photo='$newName' WHERE id='$id'");

        // Update session (important 🔥)
        $_SESSION['photo'] = $newName;

        echo "success";
    }
}
?>