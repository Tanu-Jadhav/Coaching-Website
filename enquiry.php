<?php include("../config/db.php"); ?>

<link rel="stylesheet" href="../assets/css/enquiry.css">

<?php
$msg = "";

if(isset($_POST['submit'])){

    $name       = mysqli_real_escape_string($conn, $_POST['name']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $alt_phone  = mysqli_real_escape_string($conn, $_POST['alt_phone']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $course     = mysqli_real_escape_string($conn, $_POST['course']);
    $batch      = mysqli_real_escape_string($conn, $_POST['class']); // 👈 map class → batch
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

<section class="enquiry-section">
    <div class="container">
        <h2>Student Enquiry Form</h2>

        <?php if($msg){ ?>
            <p class="success"><?php echo $msg; ?></p>
        <?php } ?>

        <form method="POST" class="enquiry-form">

            <div class="form-group">
                <input type="text" name="name" placeholder="Full Name" required>
            </div>

            <div class="form-group">
                <input type="text" name="phone" placeholder="WhatsApp Number" required>
            </div>

            <div class="form-group">
                <input type="text" name="alt_phone" placeholder="Alt. WhatsApp Number">
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="E-mail" required>
            </div>

            <div class="form-group">
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

            <div class="form-group">
                <select name="class" required>
                    <option value="">Select Batch</option>
                    <option>Morning Batch</option>
                    <option>Afternoon Batch</option>
                    <option>Evening Batch</option>
                </select>
            </div>

            <div class="form-group">
                <textarea name="message" placeholder="Your Message"></textarea>
            </div>

            <div class="buttons">
                <button type="reset" class="clear-btn">Clear All</button>
                <button type="submit" name="submit" class="submit-btn">Submit</button>
            </div>

        </form>
    </div>
</section>

