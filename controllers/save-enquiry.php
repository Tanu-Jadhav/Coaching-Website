<?php
include("../config/db.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){

    // GET DATA
    $course    = mysqli_real_escape_string($conn, $_POST['course']);
    $name      = mysqli_real_escape_string($conn, $_POST['name']);
    $phone     = mysqli_real_escape_string($conn, $_POST['phone']);
    $alt_phone = isset($_POST['alt_phone']) ? mysqli_real_escape_string($conn, $_POST['alt_phone']) : '';
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $batch     = isset($_POST['batch']) ? mysqli_real_escape_string($conn, $_POST['batch']) : '';
    $message   = isset($_POST['message']) ? mysqli_real_escape_string($conn, $_POST['message']) : '';

    // VALIDATION
    if(empty($name) || empty($phone) || empty($email)){
        echo "<script>alert('Please fill all required fields'); window.history.back();</script>";
        exit();
    }

    // INSERT QUERY
    $query = "INSERT INTO enquiries 
    (name, phone, alt_phone, email, course, batch, message) 
    VALUES 
    ('$name', '$phone', '$alt_phone', '$email', '$course', '$batch', '$message')";

    if(mysqli_query($conn, $query)){
        echo "<script>
                alert('✅ Enquiry Submitted Successfully!');
                window.location.href=document.referrer;
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "Invalid Request!";
}
?>