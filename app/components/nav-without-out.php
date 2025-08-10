<?php
include_once __DIR__ . '/../../config.php';
?>
<nav class="navbar">
  <div class="nav-container">
    <!-- Toggle button (hamburger icon) for mobile -->
    <div class="menu-toggle" id="menuToggle">
      <i class="fas fa-bars"></i>
    </div>

    <!-- Navigation Links -->
    <ul class="nav-links" id="navLinks">
      <li><a href="<?= $base_url ?>index.php?page=landing-page">Home</a></li>
      <li><a href="<?= $base_url ?>index.php?page=about">About Us</a></li>
      <li><a href="<?= $base_url ?>index.php?page=help">Help</a></li>
    </ul>
  </div>
</nav>

<!-- Responsive Navbar JS -->
 <script>
const BASE_URL = "<?= $base_url ?>";
</script>
<script src="<?= $base_url ?>app/assets/js/hamburger.js"></script>
<script src="<?= $base_url ?>app/assets/js/footer.js"></script>
