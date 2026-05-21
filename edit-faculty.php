<?php
include("../config/db.php");
include("../includes/header.php");
include("../includes/navbar.php");

// CHECK ID
if(!isset($_GET['id'])){
    echo "Invalid Request!";
    exit();
}

$id = (int)$_GET['id'];

// FETCH DATA
$result = mysqli_query($conn, "SELECT * FROM faculty WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if(!$data){
    echo "Faculty not found!";
    exit();
}

// UPDATE
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $qualification = $_POST['qualification'];
    $experience = $_POST['experience'];
    $subjects = $_POST['subjects'];

    // IMAGE UPLOAD
    if(!empty($_FILES['photo']['name'])){

        $photo = $_FILES['photo']['name'];
        $tmp = $_FILES['photo']['tmp_name'];

        move_uploaded_file($tmp, "../uploads/images".$photo);

    } else {
        $photo = $data['photo']; // old image
    }

    // UPDATE QUERY
    mysqli_query($conn, "UPDATE faculty SET 
        name='$name',
        designation='$designation',
        qualification='$qualification',
        experience='$experience',
        subjects='$subjects',
        photo='$photo'
        WHERE id=$id
    ");

    echo "<script>
        alert('Faculty Updated Successfully!');
        window.location='../admin/manage-faculty.php';
    </script>";
}
?>

<link rel="stylesheet" href="../assets/css/edit-faculty.css">

<section class="edit-section">

    <!-- HEADER -->
    <div class="header">
        <h2>Edit Faculty</h2>
        <a href="../admin/manage-faculty.php" class="back-btn">←</a>
    </div>

    <form method="POST" enctype="multipart/form-data" class="edit-form">

        <img src="../uploads/images/<?php echo $data['photo']; ?>" class="preview">

        <input type="file" name="photo">

        <input type="text" name="designation" value="<?php echo $data['designation']; ?>" placeholder="Designation" required>

        <input type="text" name="name" value="<?php echo $data['name']; ?>" placeholder="Name" required>

        <input type="text" name="qualification" value="<?php echo $data['qualification']; ?>" placeholder="Qualification" required>

        <input type="text" name="experience" value="<?php echo $data['experience']; ?>" placeholder="Experience" required>

        <input type="text" name="subjects" value="<?php echo $data['subjects']; ?>" placeholder="Subjects" required>

        <button name="update">Update Faculty</button>

    </form>

</section>

<?php include("../includes/footer.php"); ?>