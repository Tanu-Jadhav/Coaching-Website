<?php include("../config/db.php"); ?>
<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>
<?php include("floating-buttons.php"); ?>

<link rel="stylesheet" href="../assets/css/contact.css">

<!-- 🔷 PAGE TITLE -->
<section class="page-header">
    <h1>Get In Touch</h1>
</section>

<!-- 🔷 TOP CTA -->
<section class="top-cta">
    <h2>Are you getting struggle to find your right course?</h2>
    <p>We will help you</p>

    <a href="tel:8888809416" class="btn-call">
        📞 Talk to our Career Counsellor
    </a>
</section>

<!-- 🔷 GOOGLE MAP -->
<section class="map">
    <iframe 
        src="https://www.google.com/maps?q=Pune&output=embed"
        loading="lazy">
    </iframe>
</section>

<!-- 🔷 BRANCHES -->
<section class="branches">

    <div class="branch-card">
        <img src="../uploads/b1.jpg">
        <h3>Main Branch</h3>
        <p>Karve Nagar, Pune</p>
        <a href="https://www.google.com/maps?q=Karve+Nagar+Pune" target="_blank">View Map</a>
        <p class="call">Call: 9283447955</p>
    </div>

    <div class="branch-card">
        <img src="../uploads/b2.jpg">
        <h3>Deccan Branch</h3>
        <p>Shivajinagar, Pune</p>
        <a href="https://www.google.com/maps?q=Karve+Nagar+Pune" target="_blank">View Map</a>
        <p class="call">Call: 9283447955</p>
    </div>

    <div class="branch-card">
        <img src="../uploads/b3.jpg">
        <h3>Chinchwad Branch</h3>
        <p>Pimpri Chinchwad</p>
        <a href="https://www.google.com/maps?q=Pimpari+Chinchwad+Pune" target="_blank">View Map</a>
        <p class="call">Call: 9283447955</p>
    </div>

    <div class="branch-card">
        <img src=".../uploads/b4.jpg">
        <h3>Nagpur Branch</h3>
        <p>Nagpur, Maharashtra</p>
        <a href="https://www.google.com/maps?q=Nagpur+Pune" target="_blank">View Map</a>
        <p class="call">Call: 9283447955</p>
    </div>

    <div class="branch-card">
        <img src="../uploads/b5.jpg">
        <h3>Hadapsar Branch</h3>
        <p>Hadapsar, Pune</p>
        <a href="https://www.google.com/maps?q=Hadapsar+Pune" target="_blank">View Map</a>
        <p class="call">Call: 9283447955</p>
    </div>

</section>

<!-- 🔷 BOTTOM CTA -->

<section class="cta">
<h2>Lets Connect...</h2>
<p>Get Trained Get Hired</p>
<button onclick="openModal()" class="cta-btn">Are you Interested?</button>
</section>

<!-- MODAL -->
<div id="modal" class="modal">

    <div class="modal-overlay" onclick="closeModal()"></div>

    <div class="modal-container">

        <span class="close-btn" onclick="closeModal()">×</span>
        <div class="hero-left">
        <img src="../uploads/contact.png" alt="Contact">
    </div>

        <h2>Contact Us</h2>
        <p class="tagline">🚀 Become Job Ready with Industry Experts</p>

        <!-- ✅ WRITE YOUR FORM HERE -->
        <form action="../controllers/save-enquiry.php" method="POST">

            <input type="hidden" name="course" value="General Enquiry">

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

<!-- 🔷 REFER SECTION -->
<section class="refer">

    <div class="refer-left">
        <img src="../uploads/refer.png">
    </div>

    <div class="refer-right">
        <h2>🎯 Get Trained. Get Hired.</h2>
        <p>
            Join our referral program and help your friends start their IT journey while you earn rewards.
        </p>

        <ul>
            <li>✔ Refer for Java, Python, Full Stack</li>
            <li>✔ Earn cashback & discounts</li>
            <li>✔ Help them get job-ready</li>
        </ul>

        <a href="refer.php" class="refer-btn">Refer Your Friend Now 👍</a>
    </div>

</section>

<!-- 🔷 CONTACT FORM -->
<section class="contact-form" id="contactForm">

    <h2>Contact Us</h2>

    <form action="../controllers/save-contact.php" method="POST">

        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="subject" placeholder="Subject">

        <textarea name="message" placeholder="Your Message" required></textarea>

        <button type="submit">Send Message</button>

    </form>

</section>

<script>
function openModal(){
    document.getElementById("modal").style.display="flex";
}
function closeModal(){
    document.getElementById("modal").style.display="none";
}
</script>

<?php include("../includes/footer.php"); ?>