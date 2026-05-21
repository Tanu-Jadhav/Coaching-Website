<?php
include("../config/db.php");
include("../includes/header.php");

$query = mysqli_query($conn, "
    SELECT e.*, u.name AS user_name, c.name AS course_name
    FROM enrollments e
    JOIN users u ON e.user_id = u.id
    JOIN batches b ON e.batch_id = b.id
    JOIN courses c ON b.course_slug = c.slug
    ORDER BY e.id DESC
");
?>

<h2>All Enrollments</h2>

<table border="1" cellpadding="10">
<tr>
    <th>User</th>
    <th>Course</th>
    <th>Status</th>
    <th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($query)) { ?>
<tr>
    <td><?= $row['user_name'] ?></td>
    <td><?= $row['course_name'] ?></td>
    <td><?= $row['status'] ?></td>
    <td><?= $row['created_at'] ?></td>
</tr>
<?php } ?>

</table>