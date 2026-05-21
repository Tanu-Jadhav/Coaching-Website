<?php
include("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['message'])) {

        $message = trim($_POST['message']);

        if (!empty($message)) {

            // Secure input
            $message = mysqli_real_escape_string($conn, $message);

            $query = "INSERT INTO chat_messages (sender, message) 
                      VALUES ('user', '$message')";

            mysqli_query($conn, $query);

            echo "success";
        } else {
            echo "empty";
        }

    } else {
        echo "no_message";
    }

} else {
    echo "invalid_request";
}
?>