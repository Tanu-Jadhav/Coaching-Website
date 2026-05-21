<?php
$base_url = "http://localhost/coaching/";
?>

<link rel="stylesheet" href="<?= $base_url ?>assets/css/navbar.css">
<!-- Bootstrap JS (Required for dropdown) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<footer class="footer">
  <div class="container">

    <div class="row">

      <!-- ===== 1. LOGO + INFO ===== -->
      <div class="col-lg-3">
        <h4 class="footer-logo">Institute</h4>

        <p class="footer-text">
          We provide industry-ready training in Java, Full Stack and Data Science 
          with placement support.
        </p>

        <p class="contact-info"><i class="fas fa-phone"></i> <a href="tel:+918888809416"> +91 8888809416</a></p>
        <p class="contact-info"><i class="fas fa-envelope"></i> <a href="mailto:info@institute.com"> info@institute.com</a></p>
        <p class="contact-info"><i class="fas fa-map-marker-alt"></i> Pune, Maharashtra.</p>
      </div>

      <!-- ===== 2. QUICK LINKS ===== -->
      <div class="col-lg-3">
        <h5 class="footer-heading">Quick Links</h5>
        <ul class="footer-links">
          <li><a href="<?= $base_url ?>pages/index.php">Home</a></li>
          <li><a href="<?= $base_url ?>pages/about.php">About</a></li>
          <li><a href="<?= $base_url ?>pages/courses.php">Courses</a></li>
          <li><a href="<?= $base_url ?>pages/faculty.php">Faculty</a></li>
          <li><a href="<?= $base_url ?>pages/results.php">Results</a></li>
          <li><a href="<?= $base_url ?>pages/gallery.php">Gallery</a></li>
          <li><a href="<?= $base_url ?>admin/downloads.php">Downloads</a></li>
          <li><a href="<?= $base_url ?>pages/contact.php">Contact</a></li>
          <li><a href="<?= $base_url ?>privacy-policy">Privacy Policy</a></li>
        </ul>
      </div>

      <!-- ===== 3. COURSES ===== -->
      <div class="col-lg-3">
        <h5 class="footer-heading">Important Courses</h5>
        <ul class="footer-links">
          <li><a href="<?= $base_url ?>course/java-fullstack">Java Full Stack</a></li>
          <li><a href="<?= $base_url ?>course/python-fullstack">Python Fullstack</a></li>
          <li><a href="<?= $base_url ?>course/mern-stack">MERN Stack</a></li>
          <li><a href="<?= $base_url ?>course/react-developer">React Developer</a></li>
          <li><a href="<?= $base_url ?>course/data-science">Data Science</a></li>
        </ul>
      </div>

      <!-- ===== 4. GOOGLE MAP ===== -->
      <div class="col-lg-3">
        <h5 class="footer-heading">Our Location</h5>
        <p class="contact-info"><i class="fas fa-map-marker-alt"></i> <a href="https://www.google.com/maps/search/?api=1&query=Sarthi hospital Giridhar Nagar, Warje, Pune,Maharashtra" target="_blank">
    Warje Pune, Maharashtra</a></p>
        <p class="contact-info"><i class="fas fa-map-marker-alt"></i> <a href="https://www.google.com/maps/search/?api=1&query=Chandani Chowk, Pune,Maharashtra" target="_blank">
    Chandani Chowk Pune, Maharashtra</a></p>
        <p class="contact-info"><i class="fas fa-map-marker-alt"></i> <a href="https://www.google.com/maps/search/?api=1&query=Pune,Maharashtra" target="_blank">
    Pune, Maharashtra</a></p>
        <p class="contact-info"><i class="fas fa-map-marker-alt"></i> <a href="https://www.google.com/maps/search/?api=1&query=Pune,Maharashtra" target="_blank">
    Pune, Maharashtra</a></p>
        <p class="contact-info"><i class="fas fa-map-marker-alt"></i> <a href="https://www.google.com/maps/search/?api=1&query=Pune,Maharashtra" target="_blank">
    Pune, Maharashtra</a></p>
      </div>

    </div>


  </div>

  <!-- ===== SOCIAL ===== -->
    <div class="footer-social-center">
      <h6 class="connect-title">Connect with us</h6>

      <div class="footer-social">
        <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>

    <!-- ===== COPYRIGHT ===== -->
    <div class="footer-bottom">
      © <?= date("Y") ?> Coaching Institute | All Rights Reserved.
    </div>

</footer>