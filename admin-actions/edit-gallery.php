<?php include("../config/db.php"); ?>

<?php
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM gallery WHERE id=$id"));

if(isset($_POST['update'])){
    $title = $_POST['title'];
    $category = $_POST['category'];

    if($_FILES['image']['name']){
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image);

        mysqli_query($conn, "UPDATE gallery 
        SET title='$title', category='$category', image='$image' 
        WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE gallery 
        SET title='$title', category='$category' 
        WHERE id=$id");
    }

    header("Location: ../admin/manage-gallery.php");
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?php echo $data['title']; ?>">

    <select name="category">
        <option <?php if($data['category']=="Classroom") echo "selected"; ?>>Classroom</option>
        <option <?php if($data['category']=="Events") echo "selected"; ?>>Events</option>
        <option <?php if($data['category']=="Awards") echo "selected"; ?>>Awards</option>
        <option <?php if($data['category']=="Activities") echo "selected"; ?>>Activities</option>
    </select>

    <img src="../uploads/images/<?php echo $data['image']; ?>" width="100"><br>

    <input type="file" name="image">

    <button name="update">Update</button>
</form>