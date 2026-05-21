<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>
<link rel="stylesheet" href="../assets/css/demo.css">

<section class="demo-page">

    <div class="demo-container">

        <h1>Book a <span>Free Demo Class</span></h1>
        <p class="demo-offer">Exciting offers are available for you. Hurry Up!!!</p>

        <?php if(isset($_GET['success'])) { ?>
            <div class="success-msg">
                🎉 Your demo class is booked! We will contact you soon.
            </div>
        <?php } ?>

        <form action="../controllers/save-demo.php" method="POST" class="demo-form">

            <div class="form-group">
                <label>Your Name*</label>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>

            <div class="form-group">
                <label>Phone Number*</label>
                <input type="tel" name="phone" placeholder="Enter phone number" required>
            </div>

            <div class="form-group">
                <label>Your Email*</label>
                <input type="email" name="email" placeholder="Enter email" required>
            </div>

            <div class="form-group">
                <label>Select Course*</label>
                <select name="course" required>
                    <option value="">-- Select Course --</option>
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

            <button type="submit" class="demo-submit">
                Book Your Slot →
            </button>

        </form>

    </div>

</section>

<?php include("../includes/footer.php"); ?>