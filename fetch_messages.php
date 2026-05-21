<?php
include("../config/db.php");

$query = "SELECT * FROM chat_messages ORDER BY id ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "<div class='msg bot'>Error loading messages</div>";
    exit;
}

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

        $sender = $row['sender'];
        $message = htmlspecialchars($row['message']);

        $class = ($sender == 'user') ? 'user' : 'bot';

        echo "<div class='msg $class'>$message</div>";
    }

} else {

    echo "<div class='msg bot'>No messages yet</div>";
}
?>