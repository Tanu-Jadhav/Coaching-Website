<?php
include("../config/db.php");

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];

    $delete = mysqli_query($conn, "DELETE FROM enquiries WHERE id=$id");

    if($delete){
        echo "success";
    } else {
        echo "error";
    }
}
?>