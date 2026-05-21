<?php include("../config/db.php"); ?>

<link rel="stylesheet" href="../assets/css/admin.css">

<h2>Manage Gallery</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Title</th>
        <th>Category</th>
        <th>Action</th>
    </tr>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");

    while($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?php echo $row['id']; ?></td>

        <td>
            <img src="../uploads/images/<?php echo $row['image']; ?>" width="80">
        </td>

        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['category']; ?></td>

        <td>
            <a href="../admin-actions/edit-gallery.php?id=<?php echo $row['id']; ?>">Edit</a> |
            <a href="../admin-actions/delete-gallery.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>