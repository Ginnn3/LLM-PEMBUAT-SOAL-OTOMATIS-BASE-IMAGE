<?php include_once(__DIR__ . '/../../config.php'); ?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create Question</title>
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/create-tc.css" />
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">
</head>
<body>

  <?php include(__DIR__ . '/../components/navbar.php'); ?>

  <!-- Main Content -->
  <div class="main-content"> 
    <div class="main-left">
      <img src="<?= $base_url ?>app/assets/images/mainteacher.svg" alt="Main Illustration" />
      <div class="btn-create">
      <a href="<?= $base_url ?>app/teacher/upload-tc-medium.php">Create Question</a>
      </div>
    </div>
  </div>

  <?php include(__DIR__ . '/../components/footer.php'); ?>
<script src="<?= $base_url ?>app/assets/js/footer.js"></script>

</body>
</html>
