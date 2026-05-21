<?php 
include("../includes/header.php"); 
include("../includes/navbar.php"); 
include("floating-buttons.php"); 
include("../config/db.php");

if(!isset($_GET['slug'])){
    echo "Invalid Request!";
    exit();
}

$slug = trim($_GET['slug']);

$query = mysqli_query($conn, "SELECT * FROM courses WHERE LOWER(slug)=LOWER('$slug')");
$course = mysqli_fetch_assoc($query);

if(!$course){
    echo "Course not found!";
    exit();
}
?>

<link rel="stylesheet" href="../assets/css/course_details.css">

<!-- HERO -->
<section class="hero">

    <div class="hero-right">
        <h1><?= $course['name'] ?></h1>
        <p class="tagline">🚀 Become Job Ready with Industry Experts.</p>

        <button class="enroll-btn" onclick="openModal()">Enroll Now</button>
        <a href="tel:+918888888888" class="call-btn">📞 Call Now</a>
    </div>

</section>

<!-- ABOUT -->
<section class="section">
<h2>About the Course</h2>
<p><?= nl2br($course['description']) ?></p>
</section>

<!-- ELIGIBILITY -->
<section class="section light">
<h2>Who should enroll?</h2>
<ul class="list two-column-list">
<?php 
$elig = explode(",", $course['eligibility']);
foreach($elig as $e){
?>
<li><?= trim($e) ?></li>
<?php } ?>
</ul>
</section>

<!-- CURRICULUM -->
<section class="section">
<h2>Course Curriculum</h2>
<div class="grid">
<?php 
$subs = explode(",", $course['subjects']);
foreach($subs as $s){
?>
<div class="grid-card"><?= trim($s) ?></div>
<?php } ?>
</div>
</section>

<!-- HIGHLIGHTS -->
<section class="section dark">
<h2>Course Highlights</h2>
<ul class="list white two-column-list">
<?php 
$high = explode(",", $course['highlights']);
foreach($high as $h){
?>
<li><?= trim($h) ?></li>
<?php } ?>
</ul>
</section>

<!-- BATCHES -->
<section class="section">
<h2>Upcoming Batches</h2>

<div class="batch-grid">
<?php
$batchQuery = mysqli_query($conn, "SELECT * FROM batches WHERE course_slug='$slug'");

while($b = mysqli_fetch_assoc($batchQuery)) {
$isFull = ($b['filled_seats'] >= $b['seats']);
?>

<div class="batch-card">
    <h4><?= $course['name'] ?></h4>
    <p><b>Start:</b> <?= $b['start_date'] ?></p>
    <p><b>Duration:</b> <?= $b['duration'] ?></p>

    <span class="<?= $isFull ? 'full' : 'available' ?>">
        <?= $isFull ? 'Full' : 'Seats Available' ?>
    </span>

    <?php if(!$isFull){ ?>
        <a href="../user-actions/enroll.php?batch_id=<?= $b['id'] ?>" class="join">Join Now</a>
    <?php } else { ?>
        <button class="disabled">Full</button>
    <?php } ?>
</div>

<?php } ?>
</div>
</section>

<!-- CTA -->
<section class="cta">
<h2>Lets Connect...</h2>
<p>Get Trained Get Hired</p>
<button onclick="openModal()" class="cta-btn">Are you Interested?</button>
</section>

<!-- MODAL (ONLY ONE) -->
<!-- MODAL -->
<div id="modal" class="modal">

    <div class="modal-overlay" onclick="closeModal()"></div>

    <div class="modal-container">

        <span class="close-btn" onclick="closeModal()">×</span>
        <div class="hero-left">
        <img src="../uploads/images/<?= $course['image'] ?>" alt="">
    </div>

        <h2><?= $course['name'] ?></h2>
        <p class="tagline">🚀 Become Job Ready with Industry Experts</p>

        <!-- ✅ WRITE YOUR FORM HERE -->
        <form action="../controllers/save-enquiry.php" method="POST">

            <input type="hidden" name="course" value="<?= $course['name'] ?>">

            <input type="text" name="name" placeholder="Your Name" required>
            <input type="text" name="phone" placeholder="Contact Number" required>

            <input type="text" name="alt_phone" placeholder="Alternate Number (optional)">
            <input type="email" name="email" placeholder="Email Address" required>

            <select name="batch">
                <option value="">Select Batch</option>
                <option>Morning Batch</option>
                <option>Afternoon Batch</option>
                <option>Evening Batch</option>
                <option>Weekend Batch</option>
            </select>

            <textarea name="message" placeholder="Your Message"></textarea>

            <button type="submit">📞 Request Callback</button>

        </form>

        <p class="modal-call">📞 +91 8888888888</p>

    </div>

</div>

<?php include("../includes/footer.php"); ?>

<script>
function openModal(){
    document.getElementById("modal").style.display="flex";
}
function closeModal(){
    document.getElementById("modal").style.display="none";
}
</script>