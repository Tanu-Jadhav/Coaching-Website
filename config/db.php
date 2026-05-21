<?php
$conn = mysqli_connect("localhost", "root", "Tanu@2207", "institute");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}
?>
