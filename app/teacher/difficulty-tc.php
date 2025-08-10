<?php include_once(__DIR__ . '/../../config.php'); ?>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Difficulty Selection Teacher</title>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/difficulty-tc.css" />
    <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">
  </head>
  <body>
  <?php include(__DIR__ . '/../components/navbar.php'); ?>

    <!-- Main Content -->
    <div class="container">
      <h2 id="animatedText"></h2>
      <p id="p1"></p>
      <p id="p2"></p>
      <p id="p3"></p>
      <div class="difficulty-buttons">
        <a href="<?= $base_url ?>app/teacher/create-tc-hard.php" class="Hard">Hard</a>
        <a href="<?= $base_url ?>app/teacher/create-tc-medium.php" class="Medium">Medium</a>
        <a href="<?= $base_url ?>app/teacher/create-tc-easy.php" class="easy">Easy</a>
      </div>
      <div class="walker-character"></div>
    </div>
    <?php include(__DIR__ . '/../components/footer.php'); ?>

    <!-- Scripts -->
    <script src="<?= $base_url ?>app/assets/js/difficulty-tc.js"></script>
    <script src="<?= $base_url ?>app/assets/js/footer.js"></script>
  </body>
</html>
