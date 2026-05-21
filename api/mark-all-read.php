<?php
include("../config/db.php");

mysqli_query($conn, "UPDATE notifications SET is_read=1");