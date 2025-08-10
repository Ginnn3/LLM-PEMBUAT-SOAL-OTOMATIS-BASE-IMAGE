<?php
include_once __DIR__ . '/../../config.php';
?>
<nav class="navbar">
  <div class="nav-container">
    <!-- Menu Toggle untuk Mobile -->
    <div class="menu-toggle" id="menuToggle">
      <i class="fas fa-bars"></i>
    </div>

    <!-- Navigasi Link -->
    <ul class="nav-links" id="navLinks">
      <li><a href="<?= $base_url ?>index.php?page=home">Home</a></li>
      <li><a href="<?= $base_url ?>index.php?page=about">About Us</a></li>
      <li><a href="<?= $base_url ?>index.php?page=help">Help</a></li>
    </ul>

    <!-- Tombol Logout -->
    <div class="nav-right">
      <button class="logout-btn" id="logoutBtn" title="Logout">
        <i class="fas fa-sign-out-alt"></i>
      </button>
    </div>
  </div>
</nav>

<!-- SweetAlert + Logout JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  const BASE_URL = "<?= $base_url ?>";
</script>
<script src="<?= $base_url ?>app/assets/js/logout.js"></script>
<script src="<?= $base_url ?>app/assets/js/hamburger.js"></script>
<script src="<?= $base_url ?>app/assets/js/footer.js"></script>
