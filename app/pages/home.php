<?php
require_once __DIR__ . '/../../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>

  <!-- Load CSS -->
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/home.css" />
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">
</head>
<body>

<?php include_once(__DIR__ . '/../components/nav-without-out.php'); ?>

  <!-- Main Container -->
  <main>
    <h1>Choose Role!</h1>
    <div class="role-container">

      <!-- Teacher Role -->
      <div class="role">
        <img src="<?= $base_url ?>app/assets/images/teacher.png" alt="Teacher" class="role-image" />
        <h2>Teacher</h2>
        <div class="buttons">
          <a href="<?= $base_url ?>app/auth/sign-tc.php" class="btn">Sign Up</a>
          <a href="<?= $base_url ?>app/auth/login-tc.php" class="btn">Login</a>
        </div>
      </div>

      <!-- General Role -->
      <div class="role">
        <img src="<?= $base_url ?>app/assets/images/general.png" alt="General" class="role-image" />
        <h2>General</h2>
        <div class="buttons">
          <a href="<?= $base_url ?>app/auth/sign-general.php" class="btn">Sign Up</a>
          <a href="<?= $base_url ?>app/auth/login-general.php" class="btn">Login</a>
        </div>
      </div>
    </div>
  </main>
  <!-- footer -->
  <?php include_once(__DIR__ . '/../components/footer.php'); ?>
<script src="<?= $base_url ?>app/assets/js/footer.js"></script>


</body>
</html>
