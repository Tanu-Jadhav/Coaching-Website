<?php 
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Floating CSS -->
<link rel="stylesheet" href="../assets/css/floating.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Floating Buttons -->
<div class="floating-buttons">

    <!-- WhatsApp -->
    <a href="https://wa.me/919960377654" target="_blank" class=" whatsapp-btn">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Live Chat -->
    <a href="chat.php" class=" chat-btn">
        <i class="fas fa-comment-dots"></i>
    </a>

<!-- Demo Vertical Button (ONLY selected pages) -->
<?php if(
    $currentPage == "courses.php" || 
    $currentPage == "upcoming-batches.php" || 
    $currentPage == "course_details.php"
) { ?>
    <a href="demo.php" class="demo-vertical">
       <i class="fa fa-calendar-check"></i> Book Free Demo 
    </a>
<?php } ?>

</div>

<!-- Scroll Top -->
<button onclick="scrollToTop()" class="scroll-top">↑</button>

<script>
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}
</script>