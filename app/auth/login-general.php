<?php
include_once __DIR__ . '/../../config.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>General Login</title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/login-tc.css" />
    <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <?php include_once(__DIR__ . '/../components/nav-without-out.php'); ?>

    <!-- Main Content -->
    <main>
      <div class="container">
        <div class="image-container">
          <img src="<?= $base_url ?>app/assets/images/iconlogin.svg" alt="Login Illustration" />
        </div>

        <!-- Login Form -->
        <div class="form-container">
          <h2>Login For General</h2>
          <p>Please enter your login credentials</p>
          <form action="<?= $base_url ?>app/auth/proses_login_general.php" method="post">
            <input
              type="text"
              placeholder="Email"
              name="email"
              required
            />
            <input
              type="password"
              placeholder="Password"
              name="kata_sandi"
              required
            />
            <button type="submit">Login</button>
            <a href="<?= $base_url ?>app/auth/sign-general.php">Don't have an account? Sign Up</a>
          </form>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <?php include_once(__DIR__ . '/../components/footer.php'); ?>
<script src="<?= $base_url ?>app/assets/js/footer.js"></script>

  </body>
</html>
