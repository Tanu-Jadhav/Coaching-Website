<?php
// ✅ CURRENT PAGE DETECT
$currentPage = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>

<link rel="stylesheet" href="./assets/css/navbar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
  <div class="container">

    <!-- LOGO -->
    <a class="navbar-brand fw-bold" href="/coaching/">Institute</a>

    <!-- TOGGLER -->
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto align-items-lg-center text-center">

        <!-- HOME -->
        <li class="nav-item">
          <a href="/coaching/pages/index.php" 
             class="nav-link <?= ($currentPage == '' || $currentPage == 'index') ? 'active' : '' ?>">
             Home
          </a>
        </li>

        <!-- ABOUT -->
        <li class="nav-item">
          <a href="/coaching/pages/about.php" 
             class="nav-link <?= (strpos($currentPage,'about') !== false) ? 'active' : '' ?>">
             About
          </a>
        </li>

        <!-- COURSES -->
        <li class="nav-item">
          <a href="/coaching/pages/courses.php" 
             class="nav-link <?= (strpos($currentPage,'courses') !== false) ? 'active' : '' ?>">
             Courses
          </a>
        </li>

        <!-- FACULTY -->
        <li class="nav-item">
          <a href="/coaching/pages/faculty.php" 
             class="nav-link <?= (strpos($currentPage,'faculty') !== false) ? 'active' : '' ?>">
             Faculty
          </a>
        </li>

        <!-- RESULTS -->
        <li class="nav-item">
          <a href="/coaching/pages/results.php" 
             class="nav-link <?= (strpos($currentPage,'results') !== false) ? 'active' : '' ?>">
             Results
          </a>
        </li>

        <!-- GALLERY -->
        <li class="nav-item">
          <a href="/coaching/pages/gallery.php" 
             class="nav-link <?= (strpos($currentPage,'gallery') !== false) ? 'active' : '' ?>">
             Gallery
          </a>
        </li>

        <!-- DOWNLOADS -->
        <li class="nav-item">
          <a href="/coaching/admin/downloads.php" 
             class="nav-link <?= (strpos($currentPage,'downloads') !== false) ? 'active' : '' ?>">
             Downloads
          </a>
        </li>

        <!-- CONTACT -->
        <li class="nav-item">
          <a href="/coaching/pages/contact.php" 
             class="nav-link <?= (strpos($currentPage,'contact') !== false) ? 'active' : '' ?>">
             Contact
          </a>
        </li>

        <!-- CTA BUTTON -->
        <li class="nav-item ms-3">
          <a href="/coaching/pages/enquiry.php" 
             class="btn custom-enroll-btn px-4 rounded-pill fw-bold shadow-sm">
             Enroll Now
          </a>
        </li>

        <!-- USER DROPDOWN -->
        <li class="nav-item dropdown ms-3">
  <a class="nav-link dropdown-toggle d-flex align-items-center"
     href="#"
     role="button"
     data-bs-toggle="dropdown"
     aria-expanded="false">

    <i class="fa fa-user-circle me-2"></i>
    <?= htmlspecialchars($userData['name'] ?? 'User') ?>
  </a>

  <ul class="dropdown-menu dropdown-menu-end">
    <li><a class="dropdown-item" href="<?= $base_url ?>auth/profile.php">Profile</a></li>
    <li><a class="dropdown-item" href="<?= $base_url ?>auth/settings.php">Settings</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item text-danger" href="<?= $base_url ?>auth/logout.php">Logout</a></li>
  </ul>
</li>

      </ul>
    </div>
  </div>
</nav>