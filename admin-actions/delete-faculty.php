<?php
include("../config/db.php");
session_start();

// 🔐 LOGIN CHECK
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

// 🚫 ALLOW ONLY POST REQUEST (SEO + SECURITY)
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: ../admin/manage-faculty.php");
    exit();
}

// 🔐 CSRF TOKEN CHECK
if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
    die("Invalid request");
}

// ✅ VALIDATE ID
if(!isset($_POST['id']) || !is_numeric($_POST['id'])){
    header("Location: ../admin/manage-faculty.php?error=Invalid ID");
    exit();
}

$id = (int) $_POST['id'];

// ✅ FETCH PHOTO
$stmt = $conn->prepare("SELECT photo FROM faculty WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if(!$data){
    header("Location: ../admin/manage-faculty.php?error=Faculty not found");
    exit();
}

// 🗑 DELETE IMAGE FILE
if(!empty($data['photo'])){
    $filePath = "../uploads/images/" . $data['photo'];
    if(file_exists($filePath)){
        unlink($filePath);
    }
}

// 🗑 DELETE FROM DATABASE
$stmt = $conn->prepare("DELETE FROM faculty WHERE id=?");
$stmt->bind_param("i", $id);

if($stmt->execute()){
    header("Location: ../admin/manage-faculty.php?success=deleted");
} else {
    header("Location: ../admin/manage-faculty.php?error=delete_failed");
}

exit();
?>