<?php
include("../config/db.php");
include("../includes/header.php");
include("../includes/navbar.php");

$result = mysqli_query($conn, "SELECT * FROM faculty");
?>

<link rel="stylesheet" href="../assets/css/manage-faculty.css">

<!-- ICONS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<section class="manage-section">

    <!-- HEADER -->
    <div class="header">
        <h1 class="title">Manage Faculty</h1>

        <a href="dashboard.php" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>

    <div class="table-container">

        <table class="faculty-table">

            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Qualification</th>
                    <th>Experience</th>
                    <th>Subjects</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)){ ?>
                <tr>

                    <!-- PHOTO -->
                    <td>
                        <img src="../uploads/images/<?php echo $row['photo']; ?>" class="faculty-img">
                    </td>

                    <!-- NAME -->
                    <td>
                        <?php echo htmlspecialchars($row['designation']." ".$row['name']); ?>
                    </td>

                    <!-- QUALIFICATION -->
                    <td><?php echo htmlspecialchars($row['qualification']); ?></td>

                    <!-- EXPERIENCE -->
                    <td><?php echo htmlspecialchars($row['experience']); ?></td>

                    <!-- SUBJECTS -->
                    <td><?php echo htmlspecialchars($row['subjects']); ?></td>

                    <!-- ACTION -->
                    <td class="action-icons">

                        <!-- EDIT -->
                        <a href="../pages/edit-faculty.php?id=<?= $row['id']; ?>" class="icon-btn edit">
                            <i class="fa fa-pen"></i>
                        </a>

                        <!-- DELETE -->
                        <a href="../admin-acions/delete-faculty.php?id=<?= $row['id']; ?>" 
                           class="icon-btn delete"
                           onclick="return confirm('Are you sure to delete?')">
                            <i class="fa fa-trash"></i>
                        </a>

                    </td>

                </tr>
                <?php } ?>
            </tbody>

        </table>

    </div>

</section>

<?php include("../includes/footer.php"); ?>