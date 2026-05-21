<?php
include("../config/db.php");
include("../includes/header.php");
include("../includes/navbar.php");

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM faculty WHERE id=$id");
$row = mysqli_fetch_assoc($query);
?>

<link rel="stylesheet" href="../assets/css/faculty-details.css">

<section class="faculty-details">

    <div class="details-card">

        <div class="profile-header">
            <img src="../uploads/images<?php echo $row['photo']; ?>" alt="Faculty">

            <h2><?php echo $row['designation']." ".$row['name']; ?></h2>

            <span class="badge-exp"><?php echo $row['experience']; ?></span>

            <p class="rating">⭐ <?php echo $row['rating']; ?>/5</p>
        </div>

        <div class="profile-info">

            <p><strong>Qualification:</strong> <?php echo $row['qualification']; ?></p>

            <p><strong>Subjects:</strong> <?php echo $row['subjects']; ?></p>

            <p><strong>Achievements:</strong> <?php echo $row['achievements']; ?></p>

            <p class="bio"><?php echo $row['bio']; ?></p>

        </div>

        <a href="faculty.php" class="back-btn">← Back to Faculty</a>

    </div>

</section>

<?php include("../includes/footer.php"); ?>