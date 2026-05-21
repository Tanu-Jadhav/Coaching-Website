<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>
<?php include("floating-buttons.php"); ?>
<?php include("../config/db.php"); ?>

<link rel="stylesheet" href="../assets/css/results.css">

<!-- ===== TOP RESULTS ===== -->
<section class="results-section">
    <h1 class="title">Top Student Results</h1>

    <div class="results-container">

        <?php
        $res = mysqli_query($conn, "SELECT * FROM results");

        while($row = mysqli_fetch_assoc($res)){
        ?>

        <div class="result-card">

            <img src="../uploads/images/<?php echo $row['photo']; ?>">

            <h3><?php echo $row['name']; ?></h3>

            <p><strong>Exam:</strong> <?php echo $row['exam']; ?></p>

            <p class="marks"><?php echo $row['marks']; ?></p>

            <span class="rank"><?php echo $row['student_rank']; ?></span>

        </div>

        <?php } ?>

    </div>
</section>

<!-- ===== ACHIEVEMENTS ===== -->
<section class="achievement-section">

    <div class="achievement-box">
        <h2>500+</h2>
        <p>Successful Students</p>
    </div>

    <div class="achievement-box">
        <h2>100%</h2>
        <p>Result Record</p>
    </div>

    <div class="achievement-box">
        <h2>50+</h2>
        <p>Top Rank Holders</p>
    </div>

</section>

<!-- ===== TESTIMONIALS ===== -->
<section class="testimonial-section">
    <h1 class="title">Student Testimonials</h1>

    <div class="testimonial-wrapper">

        <!-- LEFT ARROW -->
        <button class="arrow left" onclick="prevSlide()">❮</button>

        <!-- SLIDES -->
        <div class="slider">

            <?php
            $test = mysqli_query($conn, "SELECT * FROM testimonials");

            while($t = mysqli_fetch_assoc($test)){
            ?>

            <div class="slide">
                <img src="../uploads/images/<?php echo $t['photo']; ?>">
                <p class="message">"<?php echo $t['message']; ?>"</p>
                <h4>- <?php echo $t['name']; ?></h4>
            </div>

            <?php } ?>

        </div>

        <!-- RIGHT ARROW -->
        <button class="arrow right" onclick="nextSlide()">❯</button>

    </div>
</section>

<script>
let currentIndex = 0;
const slides = document.querySelectorAll(".slide");

function showSlide(index){
    slides.forEach((slide, i)=>{
        slide.style.display = (i === index) ? "block" : "none";
    });
}

function nextSlide(){
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
}

function prevSlide(){
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(currentIndex);
}

// auto slide
setInterval(nextSlide, 4000);

// init
showSlide(currentIndex);
</script>

<?php include("../includes/footer.php"); ?>