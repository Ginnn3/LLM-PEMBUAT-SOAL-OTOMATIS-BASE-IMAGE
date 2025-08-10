<?php
require_once __DIR__ . '/../../config.php';
?>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>English Learning - Landing Page</title>
    <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/landing-page.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">
  </head>
  <body>
    <header>
      <img src="<?= $base_url ?>app/assets/images/logolan-01.png" alt="Learn English Logo" class="logo" />
      <div class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
      </div>
      <nav id="navbar">
      <a href="<?= $base_url ?>index.php?page=home">Get Started</a>
      <a href="<?= $base_url ?>index.php?page=about">About Us</a>
      <a href="<?= $base_url ?>index.php?page=help">Help</a>
      </nav>
    </header>

    <section class="hero">
      <h2 id="animatedText"></h2>
      <p id="p1"></p>
      <h2></h2>
      <button onclick="location.href='app/pages/home.php'">
        Get Started
      </button>
    </section>

    <footer>&copy; 2025 Vission Genius Assistant. All rights reserved.</footer>
<script src="<?= $base_url ?>app/assets/js/hamburger-lp.js"></script>
<script src="<?= $base_url ?>app/assets/js/landing-page.js"></script>
  </body>
</html>
