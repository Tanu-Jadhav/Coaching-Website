<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>
<?php include("../pages/floating-buttons.php"); ?>
<?php include("../config/db.php"); ?>

<link rel="stylesheet" href="../assets/css/downloads.css">

<?php
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? '';

$where = "WHERE 1";

if($search){
    $where .= " AND title LIKE '%$search%'";
}

$order = "ORDER BY id DESC";
if($sort == "popular"){
    $order = "ORDER BY downloads_count DESC";
}

$result = mysqli_query($conn, "SELECT * FROM downloads $where $order");
?>

<h2 class="title">Downloads</h2>

<!-- SEARCH -->
<form method="GET" class="search-box">
<input type="text" name="search" placeholder="Search files">
<button>Search</button>
</form>

<!-- SORT -->
<div class="filters">
</div>

<div class="grid">

<?php while($row = mysqli_fetch_assoc($result)) {

$ext = pathinfo($row['file'], PATHINFO_EXTENSION);

$icon = "📄";
if($ext == "pdf") $icon = "📕";
if($ext == "doc") $icon = "📘";
if($ext == "zip") $icon = "🗂️";
?>

<div class="card">
<div class="icon"><?= $icon ?></div>

<h3><?= $row['title'] ?></h3>
<p><?= $row['category'] ?></p>
<small><?= $row['file_size'] ?></small>

<p>⬇ <?= $row['downloads_count'] ?></p>

<div class="btn-row">
    <a href="../uploads/documents/<?= $row['file'] ?>" target="_blank">Preview</a>
    <a href="../pages/download.php?id=<?= $row['id'] ?>" class="btn">Download</a>
</div>
</div>

<?php } ?>

</div>

<?php include("../includes/footer.php"); ?>