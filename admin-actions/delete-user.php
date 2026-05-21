<?php
include("../config/db.php");
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

if(isset($_POST['id'])){

    $id = (int) $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        header("Location: ../user-actions/user.php?deleted=1");
        exit();
    } else {
        echo "Delete failed";
    }
}
?>