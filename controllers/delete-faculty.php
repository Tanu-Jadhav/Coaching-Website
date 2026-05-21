<?php
include("../config/db.php");

// CHECK ID
if(!isset($_GET['id'])){
    die("Invalid Request!");
}

$id = (int)$_GET['id'];

// FETCH IMAGE (for delete file)
$result = mysqli_query($conn, "SELECT photo FROM faculty WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if(!$data){
    die("Record not found!");
}

// DELETE IMAGE FILE
if(!empty($data['photo']) && file_exists("../uploads/".$data['photo'])){
    unlink("../uploads/images".$data['photo']);
}

// DELETE RECORD
mysqli_query($conn, "DELETE FROM faculty WHERE id=$id");

// REDIRECT
header("Location: ../admin/manage-faculty.php?msg=deleted");
exit();
?>