<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>
<?php include("../config/db.php"); ?>
<?php include("floating-buttons.php"); ?>
<link rel="stylesheet" href="<?= $base_url ?>assets/css/index.css">

<?php
$msg = "";

if(isset($_POST['submit'])){

    $name       = mysqli_real_escape_string($conn, $_POST['name']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $alt_phone  = mysqli_real_escape_string($conn, $_POST['alt_phone']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $course     = mysqli_real_escape_string($conn, $_POST['course']);
    $batch      = mysqli_real_escape_string($conn, $_POST['class']); 
    $message    = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO enquiries 
    (name, phone, alt_phone, email, course, batch, message)
    VALUES 
    ('$name','$phone','$alt_phone','$email','$course','$batch','$message')";

    if(mysqli_query($conn, $query)){
        $msg = "✅ Enquiry Submitted Successfully!";
    } else {
        $msg = "❌ Error: " . mysqli_error($conn);
    }
}
?>

<?php
// get only 3 courses for homepage
$result = mysqli_query($conn, "SELECT * FROM courses LIMIT 3");
?>

<!-- HERO SECTION -->
<section class="hero d-flex align-items-center justify-content-center text-center">  <div class="container text-center text-white">
    <h1 class="hero-title">Build Your Future With Excellence</h1>
    <p class="hero-subtitle">Trusted Coaching Institute for Academic Success</p>

    <div class="mt-4">
      <a href="enquiry.php" class="btn btn-outline-light me-2 mb-2">Enroll Now</a>
      <a href="upcoming-batches.php" class="btn btn-outline-lightt me-2 mb-2">View Upcoming Batches</a>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="container py-5 text-center">
  <h2>About Institute</h2>
  <p>Our institute is dedicated to providing high-quality education and fostering an environment that
         encourages innovation, critical thinking, and personal growth. We aim to equip students with the knowledge,
          skills, and values needed to succeed in a rapidly changing world. With experienced faculty, modern 
          infrastructure, and a learner-centered approach, the institute strives to create future-ready individuals
           who can contribute meaningfully to society.</p>
</section>

<!-- COURSES -->
<div class="row justify-content-center g-4">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

  <div class="col-md-3 d-flex justify-content-center">
    <div class="card course-card text-center ">
      
      <h5><?= $row['name'] ?></h5>
      
      <p>
        <?= substr($row['description'], 0, 60) ?>...
      </p>

        <a href="course_details.php?slug=<?= $row['slug'] ?>" class="btn btn-sm btn-gold">
        View Details
      </a>

    </div>
  </div>

<?php } ?>

</div>

<!-- TOP STUDENTS -->
<section class="bg-light py-5">
  <div class="container text-center">
    <h2 class="mb-4">Top Students</h2>

    <div id="studentCarousel" class="carousel slide" data-bs-ride="carousel">

      <div class="carousel-inner">

        <!-- SLIDE 1 -->
        <div class="carousel-item active">
          <div class="row justify-content-center">

            <div class="col-md-3">
              <div class="card student-card">
                <img src="<?= $base_url ?>uploads/images/student1.jpg">
                <h5>Rahul</h5>
                <p>JEE - Rank 1</p>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card student-card">
                <img src="<?= $base_url ?>uploads/images/student1.jpg">
                <h5>Sneha</h5>
                <p>NEET - Rank 2</p>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card student-card">
                <img src="<?= $base_url ?>uploads/images/student1.jpg">
                <h5>Amit</h5>
                <p>MPSC - Rank 3</p>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card student-card">
                <img src="<?= $base_url ?>uploads/images/student1.jpg">
                <h5>Pooja</h5>
                <p>SSC - Rank 5</p>
              </div>
            </div>

          </div>
        </div>

        <!-- SLIDE 2 -->
        <div class="carousel-item">
          <div class="row justify-content-center">

            <div class="col-md-3">
              <div class="card student-card">
                <img src="<?= $base_url ?>uploads/images/student1.jpg">
                <h5>Rohit</h5>
                <p>JEE - Rank 6</p>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card student-card">
                <img src="<?= $base_url ?>uploads/images/student1.jpg">
                <h5>Neha</h5>
                <p>NEET - Rank 8</p>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card student-card">
                <img src="<?= $base_url ?>uploads/images/student1.jpg">
                <h5>Karan</h5>
                <p>MPSC - Rank 10</p>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card student-card">
                <img src="<?= $base_url ?>uploads/images/student1.jpg">
                <h5>Anjali</h5>
                <p>SSC - Rank 12</p>
              </div>
            </div>

          </div>
        </div>

      </div>

      <!-- CONTROLS -->
      <button class="carousel-control-prev" type="button" data-bs-target="#studentCarousel" data-bs-slide="prev">
      </button>

      <button class="carousel-control-next" type="button" data-bs-target="#studentCarousel" data-bs-slide="next">
      </button>

    </div>
  </div>
</section>

<!-- FACULTY -->
<section class="container py-5 text-center">
  <h2>Our Faculty</h2>
  <div class="row">

    <div class="col-md-3">
      <div class="card p-3">
        <img src="../uploads/images/faculty1.jpg" class="img-fluid">
        <h5>Mr. Sharma</h5>
        <p>Maths - 10 yrs exp</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-3">
        <img src="../uploads/images/faculty1.jpg" class="img-fluid">
        <h5>Mr. Sharma</h5>
        <p>Maths - 10 yrs exp</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-3">
        <img src="../uploads/images/faculty1.jpg" class="img-fluid">
        <h5>Mr. Sharma</h5>
        <p>Maths - 10 yrs exp</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-3">
        <img src="../uploads/images/faculty1.jpg" class="img-fluid">
        <h5>Mr. Sharma</h5>
        <p>Maths - 10 yrs exp</p>
      </div>
    </div>

  </div>
</section>

<!-- TESTIMONIAL -->
<section class="bg-light py-5 text-center">
  <div class="container">
    <h2 class="mb-4">Testimonials</h2>

    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">

      <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active">
          <div class="row justify-content-center">

            <div class="col-md-4">
              <div class="card testimonial-card">
                <p>"Best institute for success!"</p>
                <h6>- Rahul</h6>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card testimonial-card">
                <p>"Amazing faculty and support."</p>
                <h6>- Sneha</h6>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card testimonial-card">
                <p>"Helped me achieve my dream rank."</p>
                <h6>- Amit</h6>
              </div>
            </div>

          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
          <div class="row justify-content-center">

            <div class="col-md-4">
              <div class="card testimonial-card">
                <p>"Very supportive teachers."</p>
                <h6>- Pooja</h6>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card testimonial-card">
                <p>"Best coaching experience."</p>
                <h6>- Rohit</h6>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card testimonial-card">
                <p>"Highly recommended!"</p>
                <h6>- Neha</h6>
              </div>
            </div>

          </div>
        </div>

      </div>

      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>

      <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>

    </div>
  </div>
</section>

<!-- ===== QUICK ENQUIRY ===== -->
<section class="enquiry-section">

  <div class="container">

    <h2 class="section-title">Quick Enquiry</h2>
    <p class="section-subtitle">Get in touch with us for better guidance</p>

    <form method="POST" class="enquiry-form">

      <div class="row">

        <!-- Full Name -->
        <div class="col-md-6">
          <input type="text" name="name" placeholder="Full Name" required>
        </div>

        <!-- WhatsApp -->
        <div class="col-md-6">
          <input type="text" name="phone" placeholder="WhatsApp No" required>
        </div>

        <!-- Alt WhatsApp -->
        <div class="col-md-6">
          <input type="text" name="alt_phone" placeholder="Alt. WhatsApp No">
        </div>

        <!-- Email -->
        <div class="col-md-6">
          <input type="email" name="email" placeholder="Email" required>
        </div>

        <!-- Course -->
        <div class="col-md-6">
          <select name="course" required>
            <option value="">Select Course</option>
                    <option>MEAN/MERN Full Stack</option>
                    <option>Python Fullstack</option>
                    <option>Advanced Java J2EE</option>
                    <option>React.js developer</option>
                    <option>.NET C# Full Stack Development</option>
                    <option>Data Analytics</option>
                    <option>Data Science and ML</option>
                    <option>Java Full Stack Development with Generative AI</option>
                    <option>Automation and Manual Testing</option>
                    <option>Placement Training</option>
                    <option>Certified Scrum Master</option>
                    <option>ITIL 4 Foundation Certification Training</option>
          </select>
        </div>

        <!-- Class -->
        <div class="col-md-6">
          <select name="class" required>
            <option value="">Select Class</option>
            <option>11th</option>
            <option>12th</option>
            <option>Under Graduate</option>
            <option>Graduation</option>
            <option>Post Graduate</option>
            <option>MBA</option>
            <option>B.Tech</option>
            <option>M.Tech </option>
            <option>Diploma</option>
          </select>
        </div>

        <!-- Message -->
        <div class="col-12">
          <textarea name="message" placeholder="Your Message..." rows="4"></textarea>
        </div>

        <!-- Buttons -->
        <div class="text-center mt-3">
          <button type="reset" class="btn btn-clear">Clear</button>
          <button type="submit" name="submit" class="btn btn-submit">Submit</button>
        </div>

      </div>

    </form>

  </div>

</section>

<?php include("../includes/footer.php"); ?>