<?php
include("../config/db.php");

$id = $_POST['id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$course = $_POST['course'];
$message = $_POST['message'];

mysqli_query($conn, "UPDATE enquiry 
SET name='$name', phone='$phone', email='$email', course='$course', message='$message'
WHERE id=$id");

echo "updated";
?>