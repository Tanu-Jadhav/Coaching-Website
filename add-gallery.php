<?php include("../config/db.php"); ?>

<?php
if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $category = $_POST['category'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "../uploads/images/".$image);

    mysqli_query($conn, "INSERT INTO gallery(title, category, image)
    VALUES('$title','$category','$image')");
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required>

    <select name="category">
        <option>Classroom</option>
        <option>Events</option>
        <option>Awards</option>
        <option>Activities</option>
    </select>

    <input type="file" name="image" required>

    <button type="submit" name="submit">Upload</button>
</form>