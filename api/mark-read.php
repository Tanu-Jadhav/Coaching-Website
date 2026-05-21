<?php
include("../config/db.php");

$id = $_POST['id'];

mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE id=$id");

echo "done";