<?php include("../config/db.php"); ?>

<link rel="stylesheet" href="../assets/css/downloads-admin.css">

<h2>📥 Manage Downloads</h2>

<!-- UPLOAD FORM -->
<form method="POST" enctype="multipart/form-data" class="upload-box">

    <input type="text" name="title" placeholder="File Title" required>

    <select name="category">
        <option>Forms</option>
        <option>Syllabus</option>
        <option>Study Material</option>
        <option>Notices</option>
    </select>

    <!-- MULTIPLE FILE UPLOAD -->
    <input type="file" name="files[]" multiple required>

    <button name="upload">Upload Files</button>
</form>

<?php
if(isset($_POST['upload'])){

    $title = $_POST['title'];
    $category = $_POST['category'];

    foreach($_FILES['files']['name'] as $key => $file){

        $tmp = $_FILES['files']['tmp_name'][$key];
        $size = $_FILES['files']['size'][$key];

        $ext = pathinfo($file, PATHINFO_EXTENSION);

        $allowed = ['pdf','doc','docx','zip'];

        if(!in_array($ext, $allowed)){
            echo "Invalid file type!";
            continue;
        }

        if($size > 5 * 1024 * 1024){
            echo "File too large!";
            continue;
        }

        move_uploaded_file($tmp, "../uploads/documents/".$file);

        $sizeKB = round($size/1024) . " KB";

        mysqli_query($conn, "INSERT INTO downloads(title, category, file, file_size)
        VALUES('$title','$category','$file','$sizeKB')");
    }

    echo "<p style='color:green;'>Upload Success</p>";
}
?>

<!-- MANAGE TABLE -->
<table>
<tr>
<th>ID</th>
<th>Title</th>
<th>Category</th>
<th>Size</th>
<th>Downloads</th>
<th>Action</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM downloads ORDER BY id DESC");

while($row = mysqli_fetch_assoc($result)){
?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['title'] ?></td>
<td><?= $row['category'] ?></td>
<td><?= $row['file_size'] ?></td>
<td><?= $row['downloads_count'] ?></td>

<td>
<a href="delete-download.php?id=<?= $row['id'] ?>">Delete</a>
</td>
</tr>
<?php } ?>

</table>