<?php
include("./config/db.php");

$message = "";

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $alt_phone = $_POST['alt_phone'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $class = $_POST['class'];
    $msg = $_POST['message'];

    // ✅ SECURE INSERT
    $stmt = $conn->prepare("INSERT INTO enquiries(name,phone,alt_phone,email,course,class,message) VALUES(?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $name, $phone, $alt_phone, $email, $course, $class, $msg);

    if($stmt->execute()){
        $message = "Enquiry Submitted Successfully!";
    } else {
        $message = "Something went wrong!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

<!-- ✅ SEO -->
<title>Student Enquiry Form | Coaching Institute Pune</title>
<meta name="description" content="Submit your enquiry for courses like Java, Fullstack, Data Science. Get guidance from expert faculty in Pune.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="./assets/css/enquiry.css">
</head>

<body class="auth-body">

<section class="enquiry-section">

<div class="container">
    <h1>Student Enquiry Form</h1>
    <p class="subtitle">Fill the form to get guidance from experts</p>

    <?php if($message){ ?>
        <p class="success"><?php echo htmlspecialchars($message); ?></p>
    <?php } ?>

    <form method="POST" class="enquiry-form">

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>WhatsApp No</label>
            <input type="tel" name="phone" pattern="[0-9]{10}" required>
        </div>

        <div class="form-group">
            <label>Alt. WhatsApp No</label>
            <input type="tel" name="alt_phone" pattern="[0-9]{10}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Course</label>
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
            <label>Class</label>
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

        <div class="form-group">
            <label>Message</label>
            <textarea name="message"></textarea>
        </div>

        <div class="buttons">
            <button type="reset" class="clear-btn">Clear All</button>
            <button type="submit" name="submit" class="submit-btn">Submit</button>
        </div>

    </form>
</div>

</section>

</body>
</html>