<?php
include("../config/db.php");

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM gallery WHERE id=$id");

header("Location: ../admin/manage-gallery.php");
?>