<?php
include("../config/db.php");

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM courses WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $desc = $_POST['description'];

    mysqli_query($conn, "UPDATE courses 
    SET name='$name', description='$desc' 
    WHERE id=$id");

    header("Location: ./admin/manage_courses.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="main">

<h2>Edit Course</h2>

<form method="POST">
    <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
    <input type="text" name="description" value="<?php echo $row['description']; ?>" required>
    <button name="update">Update Course</button>
</form>

</div>

</body>
</html>