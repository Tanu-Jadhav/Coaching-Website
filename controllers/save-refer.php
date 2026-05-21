<?php
include("../config/db.php");

$name = $_POST['name'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];

$friends = $_POST['friend_name'];
$mobiles = $_POST['friend_mobile'];

for($i = 0; $i < count($friends); $i++){

    $fname = mysqli_real_escape_string($conn, $friends[$i]);
    $fmobile = mysqli_real_escape_string($conn, $mobiles[$i]);

    mysqli_query($conn, "INSERT INTO referrals 
    (name, mobile, email, friend_name, friend_mobile)
    VALUES ('$name','$mobile','$email','$fname','$fmobile')");
}

echo "<script>alert('Referral Submitted Successfully!'); window.location='../pages/refer.php';</script>";
?>