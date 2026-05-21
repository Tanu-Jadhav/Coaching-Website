<?php
session_start();

function checkLogin(){
    if(!isset($_SESSION['user_id'])){
        header("Location: ../auth/login.php");
        exit();
    }
}

function checkAdmin(){
    if($_SESSION['role'] !== 'admin'){
        header("Location: ../admin/dashboard.php");
        exit();
    }
}

function checkUser(){
    if($_SESSION['role'] !== 'user'){
        header("Location: ../admin/login.php");
        exit();
    }
}
?>