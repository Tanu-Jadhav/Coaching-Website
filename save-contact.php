<?php
include("../config/db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // 🔒 VALIDATION
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Basic validation
    if(empty($name) || empty($email) || empty($message)){
        echo "<script>alert('Please fill all required fields'); window.history.back();</script>";
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "<script>alert('Invalid email format'); window.history.back();</script>";
        exit();
    }

    // 🔐 PREPARED STATEMENT (SECURE)
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");

    if($stmt){
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if($stmt->execute()){
            echo "<script>
                alert('Message Sent Successfully!');
                window.location.href='../pages/contact.php';
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Database error!";
    }

    $conn->close();

}else{
    echo "Invalid Request!";
}
?>