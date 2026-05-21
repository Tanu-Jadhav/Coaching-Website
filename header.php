<?php
session_start();
include(__DIR__ . "/../config/db.php");

// ✅ AUTH CHECK
if(!isset($_SESSION['user_id'])){
    header("Location: /coaching/auth/login.php");
    exit();
}

// ✅ SECURE USER FETCH (Prepared Statement)
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$userData = mysqli_fetch_assoc($result);

// ✅ DYNAMIC SEO VARIABLES (DEFAULT)
$page_title = $page_title ?? "Best Coaching Institute in Pune";
$meta_desc = $meta_desc ?? "Join the best coaching institute in Pune offering Java, Fullstack, Data Science training.";
$meta_keywords = $meta_keywords ?? "coaching institute pune, java course, fullstack, data science";

// ✅ BASE URL (IMPORTANT)
$base_url = "http://localhost/coaching/";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">

  <!-- ✅ DYNAMIC SEO -->
  <title><?= htmlspecialchars($page_title) ?></title>
  <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
  <meta name="keywords" content="<?= htmlspecialchars($meta_keywords) ?>">

  <!-- ✅ RESPONSIVE -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- ✅ OPEN GRAPH -->
  <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
  <meta property="og:image" content="<?= $base_url ?>assets/images/banner.jpg">

  <!-- ✅ CANONICAL -->
  <link rel="canonical" href="<?= $base_url ?>">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap JS (Required for dropdown) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- ✅ GLOBAL CSS -->
  <link rel="stylesheet" href="<?= $base_url ?>assets/css/navbar.css">


</head>

<body>