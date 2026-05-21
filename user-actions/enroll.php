<?php
include("../config/db.php");
session_start();

// LOGIN CHECK
if(!isset($_SESSION['user_id'])){
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: ../auth/login.php");
    exit();
}

// VALIDATE BATCH
if(!isset($_GET['batch_id']) || !is_numeric($_GET['batch_id'])){
    die("Invalid Request!");
}

$batch_id = (int)$_GET['batch_id'];

// FETCH BATCH
$query = mysqli_query($conn, "SELECT * FROM batches WHERE id='$batch_id'");
$batch = mysqli_fetch_assoc($query);

if(!$batch){
    die("Batch not found!");
}

// CHECK FULL
if($batch['filled_seats'] >= $batch['seats']){
    echo "<script>alert('Batch FULL'); window.location='../pages/courses.php';</script>";
    exit();
}

// CHECK DUPLICATE
$user_id = $_SESSION['user_id'];

$check = mysqli_query($conn, "SELECT * FROM enrollments WHERE user_id='$user_id' AND batch_id='$batch_id'");
if(mysqli_num_rows($check) > 0){
    echo "<script>alert('Already Enrolled'); window.location='../pages/courses.php';</script>";
    exit();
}

// ✅ STORE IN SESSION
$_SESSION['enroll_batch_id'] = $batch_id;

// ✅ REDIRECT
header("Location: #");
exit();