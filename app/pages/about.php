<?php
include_once __DIR__ . '/../../config.php';
?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About</title>
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/about.css">
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">
</head>
<body>
<?php include_once(__DIR__ . '/../components/nav-without-out.php'); ?>

  <!-- Main Content -->
  <section class="about-section">
    <h1 class="about-title">ABOUT US</h1>
    <div class="about-content">
      <div class="text-left">
        <div id="animated-text" class="animated-text"></div>
      </div>
      <div class="image-right">
        <img src="<?= $base_url ?>app/assets/images/Aboutlogo.svg" alt="About Us Illustration" />
      </div>
    </div>
  </section>
  <?php include_once(__DIR__ . '/../components/footer.php'); ?>
  <script src="<?= $base_url ?>app/assets/js/about.js"></script>
</body>
</html>
