<?php
include("../config/db.php");
include("../includes/header.php");
include("../includes/navbar.php");

$message = "";

// INSERT
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $desc = $_POST['description'];

    mysqli_query($conn, "INSERT INTO courses(name,description)
    VALUES('$name','$desc')");

    $message = "Course Added Successfully!";
}

// DELETE
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM courses WHERE id=$id");
}

// FETCH
$result = mysqli_query($conn, "SELECT * FROM courses");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Courses</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/manage_courses.css">

    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<div class="main">

<!-- HEADER WITH BACK BUTTON -->
<div class="header">
    <h2>Manage Courses</h2>
    <a href="dashboard.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>
</div>

<!-- Success Message -->
<?php if($message){ ?>
    <p class="success"><?php echo $message; ?></p>
<?php } ?>

<!-- Add Course -->
<form method="POST">
    <input type="text" name="name" placeholder="Course Name" required>
    <input type="text" name="description" placeholder="Description" required>
    <button name="add">Add Course</button>
</form>

<!-- Display Courses -->
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Description</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['description']; ?></td>

    <td class="action-icons">
        
        <!-- EDIT -->
        <a href="../pages/edit_course.php?id=<?php echo $row['id']; ?>" class="icon-btn edit">
            <i class="fa fa-pen"></i>
        </a>

        <!-- DELETE -->
        <a href="?delete=<?php echo $row['id']; ?>" 
           class="icon-btn delete"
           onclick="return confirm('Are you sure?')">
            <i class="fa fa-trash"></i>
        </a>
    </td>
</tr>
<?php } ?>

</table>

</div>

</body>
<?php include("../includes/footer.php"); ?>
</html>