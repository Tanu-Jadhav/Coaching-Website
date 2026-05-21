<?php
include("../config/db.php");

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM downloads WHERE id=$id");

header("Location: dashboard-downloads.php");
?>