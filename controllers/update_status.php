<?php
include("../config/db.php");

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];

    $update = mysqli_query($conn, "UPDATE enquiries SET status='Done' WHERE id=$id");

    if($update){
        echo "updated";
    } else {
        echo "error";
    }
}
?>