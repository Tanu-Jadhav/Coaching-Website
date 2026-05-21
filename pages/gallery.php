<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>
<?php include("floating-buttons.php"); ?>
<?php include("../config/db.php"); ?>

<link rel="stylesheet" href="../assets/css/gallery.css">

<?php
$limit = 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$category = isset($_GET['category']) ? $_GET['category'] : '';

$where = "";
if($category != ''){
    $where = "WHERE category='$category'";
}

$result = mysqli_query($conn, "SELECT * FROM gallery $where ORDER BY id DESC LIMIT $start, $limit");

$total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM gallery $where");
$total_row = mysqli_fetch_assoc($total_query);
$total_pages = ceil($total_row['total'] / $limit);
?>

<section class="gallery-section">
    <h2 class="title">Our Gallery</h2>

    <!-- FILTER -->
    <div class="filters">
        <a href="gallery.php">All</a>
        <a href="?category=Classroom">Classroom</a>
        <a href="?category=Events">Events</a>
        <a href="?category=Awards">Awards</a>
        <a href="?category=Activities">Activities</a>
    </div>

    <!-- GRID -->
    <div class="gallery-grid">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="gallery-card">
                <img src="../uploads/images/<?php echo $row['image']; ?>" alt="">
                <div class="overlay">
                    <h3><?php echo $row['title']; ?></h3>
                    <p><?php echo $row['category']; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- PAGINATION -->
    <div class="pagination">
        <?php for($i=1; $i <= $total_pages; $i++) { ?>
            <a href="?page=<?php echo $i; ?><?php if($category) echo '&category='.$category; ?>">
                <?php echo $i; ?>
            </a>
        <?php } ?>
    </div>

</section>

<?php include("../includes/footer.php"); ?>