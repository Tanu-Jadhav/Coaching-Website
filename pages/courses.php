<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>
<?php include("floating-buttons.php"); ?>
<?php include("../config/db.php"); ?>

<link rel="stylesheet" href="../assets/css/courses.css">

<!-- TITLE -->
<h1 class="title">Our Professional Courses</h1>

<!-- INTRO -->
<section class="course-intro">
    <p>
        Choose your course with complete bundle of classroom training.
        Each training is handled by experienced professionals with real-time knowledge.
    </p>
</section>

<!-- SEARCH + FILTER -->
<section class="search-section">
    <div class="search-bar">

        <div class="search-input">
            <span>🔍</span>
            <input type="text" id="searchInput" placeholder="Search courses...">
        </div>

        <select id="courseFilter">
    <option value="all"></option>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM courses");
    while($row = mysqli_fetch_assoc($result)) {
    ?>
        <option value="<?= strtolower($row['name']) ?>">
            <?= $row['name'] ?>
        </option>
    <?php } ?>
</select>

    </div>
</section>

<!-- COURSES -->
 
<section class="course-section">
<div class="course-grid ">

<?php
$result = mysqli_query($conn, "SELECT * FROM courses");

while($row = mysqli_fetch_assoc($result)) {
?>

<div class="course-card">

    <div class="card-header">
        <?= $row['name'] ?>
    </div>

    <div class="card-body">
        <img src="../uploads/images/<?= $row['image'] ?>" alt="Courses">
    </div>

    <div class="card-footer">
        <a href="course_details.php?slug=<?= $row['slug'] ?>" class="enroll-btn">
            Enroll Now
        </a>
    </div>

</div>

<?php } ?>

</div>
</section>

<!-- WHY US -->
<section class="why-us">
    <h2>Why Only Us</h2>
    <p class="subtitle">
        Learn from working professionals with real-time scenarios.
    </p>

    <div class="why-grid">
        <div class="why-box">
        <ul class="why-list">
            <li>Owner has worked (total 15 years) in MNC at Bangalore/Noida/Pune and currently in MNC at Pune.</li>

            <li>We maintain transparency so you can come to our office and get the mobile number of students from our batches.</li>

            <li>Our institute guarantees to train you and keep you updated with latest technologies.</li>
        </ul>
    </div>
        <div class="why-box">
                <ul class="why-list">
                    <li>Meet us once and we will make sure that you will definitely be pleased and happy with us... 
                        Anyways you don't need to pay anything from your side.</li>
                    <li>(Coaching centre name) class offers a wide range of courses like Core Java Training in pune, Selenium 
                        Testing and J2EE Training in Pune to meet the growing corporate needs. We understand that individual
                         learning capabilities are different and so we offer customized course for each student. We provide 100% practical and real time training.
                    </li>
                </ul>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="stats">
    <div class="stat-box">
        <h2 class="counter" data-target="50000">0</h2>
        <p>Students Trained</p>
    </div>

    <div class="stat-box">
        <h2 class="counter" data-target="15">0</h2>
        <p>Years Experience</p>
    </div>

    <div class="stat-box">
        <h2 class="counter" data-target="25000">0</h2>
        <p>Placed Students</p>
    </div>
</section>

<?php include("../includes/footer.php"); ?>

<!-- JS -->
<script>

// COMBINED FILTER + SEARCH
function applyFilter() {
    let search = document.getElementById("searchInput").value.toLowerCase();
    let category = document.getElementById("courseFilter").value;

    let cards = document.querySelectorAll(".course-card");

    cards.forEach(card => {
        let text = card.innerText.toLowerCase();
        let cat = card.getAttribute("data-category");

        let matchSearch = text.includes(search);
        let matchCategory = (category === "all" || cat === category);

        card.style.display = (matchSearch && matchCategory) ? "block" : "none";
    });
}

document.getElementById("searchInput").addEventListener("keyup", applyFilter);
document.getElementById("courseFilter").addEventListener("change", applyFilter);

// COUNTER
document.querySelectorAll('.counter').forEach(counter => {
    const update = () => {
        const target = +counter.dataset.target;
        const c = +counter.innerText;
        const inc = target / 100;

        if(c < target){
            counter.innerText = Math.ceil(c + inc);
            setTimeout(update, 20);
        } else {
            counter.innerText = target + "+";
        }
    };
    update();
});

</script>