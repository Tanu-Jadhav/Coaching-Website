<?php
include("../config/db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name   = mysqli_real_escape_string($conn, $_POST['name']);
    $phone  = mysqli_real_escape_string($conn, $_POST['phone']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $course = mysqli_real_escape_string($conn, $_POST['course'] ?? '');

    // Insert into DB
    $query = "INSERT INTO demo_requests (name, phone, email, course) 
              VALUES ('$name', '$phone', '$email', '$course')";

    if(mysqli_query($conn, $query)){

    $msg = "Hello, I booked a demo class.%0AName: $name%0APhone: $phone%0ACourse: $course";
    
    header("Location: https://wa.me/919960377654?text=$msg");
    exit();
}
}
?>
