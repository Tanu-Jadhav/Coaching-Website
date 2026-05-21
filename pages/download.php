<?php
include("../config/db.php");

$id = $_GET['id'];

// Fetch file data
$result = mysqli_query($conn, "SELECT * FROM downloads WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if(!$data){
    die("File not found in database");
}

$file = "../uploads/" . $data['file'];

/* Check file exists */
if(!file_exists($file)){
    die("File not found in folder");
}

/* Increase download count */
mysqli_query($conn, "UPDATE downloads SET downloads_count = downloads_count + 1 WHERE id=$id");

/* Force download */
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
readfile($file);
exit;
?>