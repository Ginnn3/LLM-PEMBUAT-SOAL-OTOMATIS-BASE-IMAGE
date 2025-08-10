<?php
include_once __DIR__ . '/../../config.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Teacher Sign Up</title>
    <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/sign-tc.css" />
    <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
      input[type=number]::-webkit-outer-spin-button,
      input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }
      input[type=number] {
        -moz-appearance: textfield;
      }
    </style>
  </head>
  <body>
    <?php include_once(__DIR__ . '/../components/nav-without-out.php'); ?>

    <!-- Main Content -->
    <div class="container">
      <div class="image-container">
        <img src="<?= $base_url ?>app/assets/images/iconlogin.svg" alt="Signup Illustration" />
      </div>

      <div class="form-container">
        <h2>Teacher Sign Up</h2>
        <p>Please fill in your details below</p>
        <form action="<?= $base_url ?>app/auth/proses_signup_tc.php" method="post">
          <input type="text" name="nama" required placeholder="Full Name" />
          <input type="number" name="nig" required placeholder="Teacher ID (NIG)" />
          <input type="email" name="email" required placeholder="Email Address" />
          <input type="password" name="kata_sandi" required placeholder="Password" />
          <button type="submit">Create New Account</button>
        </form>
        <br />
        <p>Already have an account? <a href="<?= $base_url ?>app/auth/login-tc.php">Login here</a></p>
      </div>
    </div>
    <?php include_once(__DIR__ . '/../components/footer.php'); ?>
<script src="<?= $base_url ?>app/assets/js/footer.js"></script>
  </body>
</html>
