<?php
include("../config/db.php");

$result = mysqli_query($conn, 
"SELECT * FROM notifications 
WHERE is_read = 0 
ORDER BY id DESC LIMIT 6");

$data = [];

while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}

echo json_encode($data);