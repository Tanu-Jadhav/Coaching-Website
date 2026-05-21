<?php include("../config/db.php"); ?>

<form method="post">
    <input type="text" name="msg" placeholder="Reply..." required>
    <button type="submit">Send</button>
</form>

<?php
if(isset($_POST['msg'])){
    $msg = $_POST['msg'];

    mysqli_query($conn, "INSERT INTO chat_messages (sender, message) 
                         VALUES ('admin', '$msg')");
}
?>

<hr>

<?php
$result = mysqli_query($conn, "SELECT * FROM chat_messages ORDER BY id DESC");

while($row = mysqli_fetch_assoc($result)){
    echo "<p><b>{$row['sender']}:</b> {$row['message']}</p>";
}
?>